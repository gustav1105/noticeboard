require('./bootstrap')
import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import VeeValidate from 'vee-validate'
import routes from './routes.js'
import storeData from './store.js'

Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store(storeData);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    store,
})
