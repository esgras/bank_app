<template>
    <div>
        <h2>Cards list
            <button class="btn btn-primary" style="float: right" @click="createCard">Create new Card</button>
        </h2>
        <table v-if="cards" class="table">
            <tr>
                <th>Number</th>
                <th>Balance</th>
                <th>Created at</th>
                <th></th>
                <th></th>
            </tr>
            <tr v-for="card in cards">
                <td><a href="#">{{ card.number }}</a></td>
                <td>{{ card.amount }}</td>
                <td>{{ card.created_at }}</td>
                <td><a href="#">Put on card</a></td>
                <td><a href="#">Withdraw</a></td>
            </tr>
        </table>
    </div>
</template>
<script>
    export default {
        computed: {
            cards() {
                return this.$store.getters.cards;
            }
        },
        methods: {
            createCard() {
                this.$store.dispatch('createCard');
            }
        }
    }
</script>