<template>
    <div>
        <h2 class="card-list-title">
            <span>Cards List</span>
            <span style="float: right">
                <button class="btn btn-warning"
                        @click="transferMoney" v-if="cards" style="margin-right: 20px;">Transfer money</button>
                <button class="btn btn-success"
                        @click="createCard">Create new Card</button>
            </span>
        </h2>
        <table v-if="cards.length" class="table">
            <tr>
                <th>Number</th>
                <th>Balance</th>
                <th>Created at</th>
                <th></th>
                <th></th>
            </tr>
            <tr v-for="card in cards">
                <td><a href="#"
                       @click="showCard(card.id)">{{ formatNumber(card.number)
                    }}</a></td>
                <td>{{ card.amount }}</td>
                <td>{{ card.created_at }}</td>
                <td><a href="#" @click="depositCard(card.id)">Put on card</a>
                </td>
                <td><a href="#" @click="withdrawCard(card.id)">Withdraw</a></td>
            </tr>
        </table>
        <h3 v-else>There are no cards yet. You can create one.</h3>
    </div>
</template>
<style scoped="">
    .card-list-title {
        margin-bottom: 30px;
    }
</style>
<script>
    import utils from './../utils';

    export default {
        computed: {
            cards() {
                return this.$store.getters.cards;
            },
            formatNumber() {
                return utils.formatCardNumber;
            }
        },
        methods: {
            createCard() {
                this.$store.dispatch('createCard');
            },
            showCard(id) {
                this.$store.dispatch('showCardPage', {page: 'card', id});
            },
            depositCard(id) {
                this.$store.dispatch('showCardPage', {page: 'depositForm', id});
            },
            withdrawCard(id) {
                this.$store.dispatch('showCardPage', {
                    page: 'withdrawForm',
                    id
                });
            },
            transferMoney() {
                this.$store.dispatch('showCardPage', {page: 'transferForm', id: null});
            }
        }
    }
</script>