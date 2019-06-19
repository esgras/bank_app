import Vue from 'vue'
import Vuex from 'vuex'
import reqwest from 'reqwest'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        cards: [],
        ajax: false,
        cardPage: 'list',
        searchActive: false,
        selectedCard: null,
        errorText: '',
        pinCodeModal: {
            visible: false,
            callback: false,
            cardNumber: null,
            error: '',
            context: null
        },
        infoModal: {
            visible: false,
            message: ''
        }
    },
    mutations: {

        addCard(state, payload) {
            payload['operations'] = [];
            state.cards.splice(0, 0, payload);
        }
    },
    actions: {
        createCard(context, payload) {
            context.dispatch('dropOldAjax');
            if (!confirm('Do you really want to add a new card?')) return;

            let res = reqwest({
                url: `/api/v1/cards?api_token=${context.state.apiToken}`,
                method: 'post',
                success: resp => {
                    context.commit('addCard', resp);
                    context.dispatch('infoModalShow', 'Pin code - ' + resp.pin);

                },
                error: resp => {
                    alert('Something went wrong, try later.');
                    console.log(resp);
                }
            });
            context.state.ajax = res.request;
        },

        showCreateForm(context, payload) {
            context.commit('hideAllViewsExcept',  'form');
            context.commit('resetBook');
        },
        showEditForm(context, payload) {
            context.commit('hideAllViewsExcept',  'form');
            context.commit('setBook', context.getters.getBookById(payload));
        },

        showList(context, payload) {
            context.commit('hideAllViewsExcept',  'list');
            context.commit('resetBook', payload);
        },

        dropOldAjax(context, payload) {
            if (context.state.ajax) {
                context.state.ajax.abort();
            }
        },

        addMoneyToCard(context, payload) {
            context.dispatch('dropOldAjax');

            let res = reqwest({
                url: `/api/v1/cards/add-money?api_token=${context.state.apiToken}`,
                method: 'post',
                data: {id: this.state.selectedCard.id, amount: payload},
                success: resp => {
                    // resp = JSON.parse(resp);
                    if (resp.success) {
                        context.state.selectedCard.amount = +context.state.selectedCard.amount + +payload;
                        context.state.selectedCard.operations.splice(0, 0, resp.operation);
                        alert('Money was added to your card');
                    } else {
                        alert(resp.message);
                    }
                },
                error: resp => {
                    alert('Something went wrong, try later.');
                    console.log(resp);
                }
            });
            context.state.ajax = res.request;
        },
        withdrawMoneyFromCard(context, payload) {
            context.dispatch('dropOldAjax');

            let res = reqwest({
                url: `/api/v1/cards/withdraw-money?api_token=${context.state.apiToken}`,
                method: 'post',
                data: {id: this.state.selectedCard.id, amount: payload},
                success: resp => {
                    // resp = JSON.parse(resp);
                    if (resp.success) {
                        context.state.selectedCard.amount -= payload;
                        context.state.selectedCard.operations.splice(0, 0, resp.operation);
                        alert('Money was withdrawn from your card');
                    } else {
                        context.state.errorText = resp.error;
                    }
                },
                error: resp => {
                    alert('Something went wrong, try later.');
                    console.log(resp);
                }
            });
            context.state.ajax = res.request;
        },
        selectCard(context, payload) {
            context.state.selectedCard = context.state.cards.find(card => card.id === payload);
        },
        dropSelectedCard(context, payload) {
            context.state.selectedCard = null;
            context.state.cardPage = 'list';
            context.dispatch('clearErrorText');
        },
        showCardPage(context, payload) {
            context.state.cardPage = payload.page;
            context.dispatch('selectCard', payload.id);
            context.dispatch('clearErrorText');
        },
        clearErrorText(context, payload) {
            context.state.errorText = '';
        },
        transferMoney(context, payload) {
            context.dispatch('dropOldAjax');
            let destinationCardNumber = payload.destinationCard.replace(/-/g, '');

            let res = reqwest({
                url: `/api/v1/cards/money-transfer?api_token=${context.state.apiToken}`,
                method: 'post',
                data: {
                    source: payload.sourceCard,
                    destination: destinationCardNumber,
                    amount: payload.amount
                },
                success: resp => {
                    console.log(resp);
                    if (resp.success) {
                        let sourceCard = context.state.cards.find(card => card.number === payload.sourceCard);
                        sourceCard.operations.splice(0, 0, resp.sourceCardOperation);
                        sourceCard.amount -= payload.amount;

                        let destinationCard = context.state.cards.find(card => card.number === destinationCardNumber);
                        if (destinationCard) {
                            destinationCard.amount = +destinationCard.amount + +payload.amount;
                            destinationCard.operations.splice(0, 0, resp.destinationCardOperation);
                        }
                        alert('Money was transferred');
                    } else {
                        context.state.errorText = resp.error;
                    }
                },
                error: resp => {
                    alert('Something went wrong, try later.');
                    console.log(resp);
                }
            });
            context.state.ajax = res.request;
        },
        pinCodeModalHide(context, payload) {
            context.state.pinCodeModal.visible = false;
            context.state.pinCodeModal.error = false;
        },
        pinCodeModalClearError(context, payload) {
            context.state.pinCodeModal.error = false;
        },
        pinCodeModalShow(context, payload) {
            context.state.pinCodeModal.visible = true;
            context.state.pinCodeModal.callback = payload.callback;
            context.state.pinCodeModal.cardNumber = payload.cardNumber;
            context.state.pinCodeModal.error = false;
        },
        pinCodeModalSetError(context, payload) {
            context.state.pinCodeModal.error = payload;
        },
        pinCodeModalCheck(context, payload) {
            context.dispatch('dropOldAjax');
            let res = reqwest({
                url: `/api/v1/cards/check-pin?api_token=${context.state.apiToken}`,
                method: 'post',
                data: {
                    number: context.state.pinCodeModal.cardNumber,
                    code: payload
                },
                success: resp => {
                    if (resp.success) {
                        context.dispatch('pinCodeModalHide');
                        context.state.pinCodeModal.callback.call();
                    } else {
                        context.state.pinCodeModal.error = resp.error;
                    }
                },
                error: resp => {
                    alert('Something went wrong, try later.');
                    console.log(resp);
                }
            });

            context.state.ajax = res.request;
        },
        pinCodeChange(context, payload) {
            context.dispatch('dropOldAjax');
            let res = reqwest({
                url: `/api/v1/cards/change-pin-code?api_token=${context.state.apiToken}`,
                method: 'post',
                data: {
                    id: payload
                },
                success: resp => {
                    if (resp.success) {
                        context.dispatch('infoModalShow', 'Pin code - ' + resp.pin);
                    } else {
                        alert(resp.error);
                    }
                },
                error: resp => {
                    alert('Something went wrong, try later.');
                    console.log(resp);
                }
            });

            context.state.ajax = res.request;
        },
        infoModalShow(context, payload) {
            context.state.infoModal.visible = true;
            context.state.infoModal.message = payload;
        },
        infoModalHide(context, payload) {
            context.state.infoModal.visible = false;
            context.state.infoModal.message = '';
        }
    },
    getters: {
        cards(state) {
            return state.cards;
        },

        selectedCard(state) {
            return state.selectedCard;
        },

        cardPage(state) {
            return state.cardPage;
        },

        errorText(state) {
            return state.errorText;
        },
        pinCodeModalVisible(state) {
            return state.pinCodeModal.visible;
        },
        pinCodeModalError(state) {
            return state.pinCodeModal.error;
        },
        infoModalMessage(state) {
            return state.infoModal.message;
        },
        infoModalVisible(state) {
            return state.infoModal.visible;
        }

    }

})