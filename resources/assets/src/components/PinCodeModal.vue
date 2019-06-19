<template>
    <div id="exampleModalLive" class="modal fade show" role="dialog"
         style="padding-right: 15px; display: block; top: 100px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center"
                        id="exampleModalLiveLabel"
                        style="width: 100%; display: block;">
                        Enter card pin code</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close" @click="close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" @submit.prevent="">
                        <div class="form-group text-center"><input type="number"
                                                                   style="width: 150px;"
                                                                   required
                                                                   pattern="^\d{4}$"
                                                                   placeholder="4 digit" v-model="pinCode">
                            <button type="button"
                                    class="btn btn-primary btn-sm" @click.prevent="submit">Submit
                            </button>
                        </div>
                        <div class="text-danger text-center">{{ error }}</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                pinCode: ''
            };
        },
        methods: {
            close() {
                this.$store.dispatch('pinCodeModalHide');
            },
            submit() {
                this.$store.dispatch('pinCodeModalClearError');
                if (this.pinCode.length != 4) {
                    this.$store.dispatch('pinCodeModalSetError', 'Pin code must have 4 digits');
                    return;
                }
                this.$store.dispatch('pinCodeModalCheck', this.pinCode);

            }
        },
        computed: {
            error() {
                return this.$store.getters.pinCodeModalError ? this.$store.getters.pinCodeModalError : '';
            }
        }
    }
</script>