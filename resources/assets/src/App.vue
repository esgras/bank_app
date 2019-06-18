<template>
  <div id="app">
    <nav>
      <!--<router-link to='/'>Cards</router-link>-->
      <!--<router-link to='/'>Cards</router-link>-->
      <!--<router-link to='/transfer'>Transfer</router-link>-->
      <!--<router-link to='/transfer'>Transfer</router-link>-->
    </nav>
    <!--<router-view></router-view>-->
    <!--<transfer-form></transfer-form>-->
    <list></list>
  </div>
</template>

<script>

import TransferForm from './components/TransferForm.vue';
import List from './components/List.vue';

export default {
    name: 'app',
    data() {
        return {
            msg: 'Your bank'
        };
    },
    components: {
        TransferForm,
        List
    }
}

//import List from './components/List.vue'
//import BookForm from './components/BookForm.vue'
//import BookView from './components/BookView.vue'

//export default {
//  name: 'app',
//  data () {
//    return {
//      msg: 'Welcome to Your Vue.js App'
//    }
//  },
//  components: {
//    List,
//    BookForm,
//    BookView
//  },
//  computed: {
//      formVisible() {
//          return this.$store.getters.formVisible;
//      },
//      listVisible() {
//          return this.$store.getters.listVisible;
//      },
//      viewVisible() {
//          return this.$store.getters.viewVisible;
//      }
//  }
//}
</script>