<template>
    <div id="exampleModalLive" class="modal fade show" role="dialog"
         style="padding-right: 15px; display: block; top: 100px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center"
                        id="exampleModalLiveLabel"
                        style="width: 100%; display: block;">
                        {{ message }}</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close" @click="close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        methods: {
            close() {
                this.$store.dispatch('infoModalHide');
            }
        },
        computed: {
            message() {
                return this.$store.getters.infoModalMessage;
            }
        }
    }
</script>