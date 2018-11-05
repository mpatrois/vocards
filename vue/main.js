import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
import routes from './routes';
import storeModules from './store/index';

Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store({
  modules: storeModules,
});

const router = new VueRouter({ routes, mode: 'history' });

Vue.prototype.$bus = new Vue({});

const vueApp = new Vue({
  el: '#app',
  router,
  store,
});

export default vueApp;
