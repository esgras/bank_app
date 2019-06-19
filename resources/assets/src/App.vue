<template>
  <div id="app">
    <card v-if="isVisibleCardPage('card')"></card>
    <deposit-form v-if="isVisibleCardPage('depositForm')"></deposit-form>
    <withdraw-form v-if="isVisibleCardPage('withdrawForm')"></withdraw-form>
    <list v-if="isVisibleCardPage('list')"></list>
    <transfer-form v-if="isVisibleCardPage('transferForm')"></transfer-form>
    <pin-code-modal v-if="pinCodeModalVisible"></pin-code-modal>
    <info-modal v-if="infoModalVisible"></info-modal>



  </div>
</template>

<script>

import TransferForm from './components/Forms/TransferForm.vue';
import List from './components/List.vue';
import Card from './components/Card.vue';
import DepositForm from './components/Forms/DepositForm.vue'
import WithdrawForm from './components/Forms/WithdrawForm.vue'
import PinCodeModal from './components/PinCodeModal.vue'
import InfoModal from './components/InfoModal.vue'

export default {
    name: 'app',
    data() {
        return {
            msg: 'Your bank'
        };
    },
    components: {
        TransferForm,
        List,
        Card,
        DepositForm,
        WithdrawForm,
        PinCodeModal,
        InfoModal
    },
    computed: {
        isVisibleCardPage() {
            return (page) => page == this.$store.getters.cardPage;
        },
        pinCodeModalVisible() {
            return this.$store.getters.pinCodeModalVisible;
        },
        infoModalVisible() {
            return this.$store.getters.infoModalVisible;
        }
    }
}
</script>