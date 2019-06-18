import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'

import routes from './routes';
import store from './store/index'

Vue.use(VueRouter);
let router = new VueRouter(routes);


let initialState = Object.assign({}, store.state, {
    cards
});
store.replaceState(initialState);

new Vue({
  el: '#app',
  render: h => h(App),
  store,
  router
});
