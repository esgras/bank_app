<template>
    <div>
        <h2 class="text-center">Deposite Money to card #{{ formatNumber(card.number) }}</h2>

        <form action="" @submit.prevent="putMoney">
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Put cash here" step="0.01" min="1" @click="clearError" v-model="amount" required>
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
                error: '',
                amount: 0
            };
        },
        methods: {
            goToList() {
                this.$store.dispatch('dropSelectedCard');
            },
            putMoney() {
                this.clearError();
                if (this.amount <= 1 || !parseFloat(this.amount)) {
                    this.error = 'Wrong money amount';
                    return;
                }



                this.$store.dispatch('addMoneyToCard', this.amount);
                this.amount = 0;
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
<style scoped="">
    form {
        margin-top: 20px;
    }
    .money-error-message {
        display: inline-block;
        margin-top: 5px;
    }
</style>