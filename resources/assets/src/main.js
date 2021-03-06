import Vue from 'vue'
import App from './App.vue'

import store from './store/index'


let initialState = Object.assign({}, store.state, {
    cards,
    apiToken
});
store.replaceState(initialState);

new Vue({
  el: '#app',
  render: h => h(App),
  store
});
