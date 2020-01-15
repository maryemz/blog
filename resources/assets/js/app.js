


require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios';
import VueAxios from 'vue-axios';
import MainVue from './components/mainVue.vue'
import routes from './routes.js'
window.Vue.use(VueRouter);
Vue.use(VueAxios, axios);
require ("vue-multiselect/dist/vue-multiselect.min.css");

const router = new VueRouter({
    mode: 'history',
    routes
});
Vue.router = router
Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

const app = new Vue({
    el: '#app',
    components :{
       MainVue	
    },
    router
});
