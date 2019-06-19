<template>
    <div>
        <h2>Card #{{ formatNumber(card.number) }}</h2>
        <p>Balance - <strong>{{ card.amount }}</strong></p>
        <p>Created - <strong>{{ card.created_at }}</strong></p>
        <button @click="goToList" class="btn btn-link btn-small">Back to list</button>
        <button @click="changePinCode" class="btn btn-danger">Change Pin Code</button>
        <div class="operations" v-if="card.operations" style="margin-top: 20px;">
            <h4>Card operations</h4>
            <table class="table">
                <tr v-for="operation in card.operations">
                    <td>{{ operation.description }}</td>
                    <td>{{ operation.created_at }}</td>
                </tr>
            </table>
        </div>
    </div>
</template>
<script>
    import utils from './../utils';

    export default {
        methods: {
            goToList() {
                this.$store.dispatch('dropSelectedCard');
            },
            changePinCode() {
                if (!confirm('Do you really want to change your pin code?')) return;

                this.$store.dispatch('pinCodeChange', this.$store.getters.selectedCard.id);
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