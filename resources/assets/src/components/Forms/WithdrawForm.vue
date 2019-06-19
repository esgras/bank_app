<template>
    <div>
        <h2 class="text-center">Widthraw Money from card #{{ formatNumber(card.number) }}</h2>
        <form action=""  @submit.prevent="withdrawnMoney">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter amount" @click="clearError" v-model="amount" required>
                <span class="text-danger money-error-message">{{ error }}</span>
            </div>
            <button class="btn btn-primary">Submit</button>
            <button @click="goToList" class="btn btn-link btn-sm">Back to list</button>
        </form>
    </div>
</template>
<script>
    import utils from './../../utils';

    export default {
        data() {
            return {
                amount: 0,
                error: ''
            };
        },
        methods: {
            goToList() {
                this.$store.dispatch('dropSelectedCard');
            },
            withdrawnMoney() {
                this.clearError();
                if (this.amount <= 1 || !parseFloat(this.amount)) {
                    this.error = 'Wrong money amount';
                    return;
                }

                let self = this;

                this.$store.dispatch('pinCodeModalShow', {
                    cardNumber: this.$store.getters.selectedCard.number,
                    callback: function() {
                        self.$store.dispatch('withdrawMoneyFromCard', self.amount);
                        self.amount = 0;
                    }
                });


            },
            clearError() {
                this.error = '';
                this.$store.dispatch('clearErrorText');
            }
        },
        computed: {
            card() {
                return this.$store.getters.selectedCard;
            },

            formatNumber() {
                return utils.formatCardNumber;
            }
        }
    }
</script>
<style>
    form {
        margin-top: 20px;
    }
    .money-error-message {
        display: inline-block;
        margin-top: 5px;
    }
</style>