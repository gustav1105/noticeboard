require('./bootstrap')
import Vue from 'vue'
import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate'
import routes from './routes.js'
import Vuetify from 'vuetify'
import axios from 'axios'

Vue.prototype.$http = axios
const bus = new Vue()
// import 'vuetify/dist/vuetify.min.css' 

Vue.use(Vuetify)
Vue.use(VeeValidate);
Vue.use(VueRouter);


const app = new Vue({
  el: '#app',
  router: new VueRouter(routes),
})

export default bus