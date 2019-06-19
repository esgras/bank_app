<template>
    <div>
        <h2 class="text-center">Money transfer</h2>

        <form action="" @submit.prevent="transferMoney" @click="clearError">
            <h4 class="text-danger text-center">{{ errorMessage }}</h4>
            <div class="form-group">
                <label for="sourceCard" class="control-label">Select source card</label>
                <select name="" id="sourceCard" v-model="sourceCard" class="form-control" required>
                    <option :value="card.number" v-for="card in cards">{{ formatNumber(card.number) + ' (' + card.amount + ')' }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sourceCard" class="control-label">Enter destination card</label>
                <input type="text" class="form-control" v-model="destinationCard" >
            </div>
            <div class="form-group">
                <label for="sourceCard" class="control-label">Enter money amount</label>
                <input type="number" class="form-control" v-model="amount" required min="1" step="0.01">
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
                sourceCard: '',
                destinationCard: '',
                amount: 0
            };
        },
        methods: {
            goToList() {
                this.$store.dispatch('dropSelectedCard');
            },
            transferMoney() {
                this.clearError();
                if (this.amount <= 1 || !parseFloat(this.amount)) {
                    this.error = 'Wrong money amount';
                    return;
                }

                let errorMessages = {
                    sourceCard: 'Source card must not be blank',
                    destinationCard: 'Destination card must not be blank'
                };

                for (let field in errorMessages) {
                    if (!this[field]) {
                        this.error = errorMessages[field];
                        return;
                    }
                }


                let self = this;

                this.$store.dispatch('pinCodeModalShow', {
                    cardNumber: this.sourceCard,
                    callback: function() {
                        self.$store.dispatch('transferMoney', {
                            sourceCard: self.sourceCard,
                            destinationCard: self.destinationCard,
                            amount: self.amount
                        });
                    }
                });



            },
            clearError() {
                this.error = '';
                this.$store.dispatch('clearErrorText');
            }
        },
        computed: {
            cards() {
                return this.$store.getters.cards;
            },

            formatNumber() {
                return utils.formatCardNumber;
            },
            errorMessage() {
                return this.error || this.$store.getters.errorText;
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