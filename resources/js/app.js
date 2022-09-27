import './bootstrap';
import Vue from 'vue';

import axios from 'axios';
import VueAxios from 'vue-axios';
import Auth from './utils/Auth.js';

Vue.prototype.auth = Auth;
Vue.use(VueAxios, axios);

import App from './App.vue';
import router from './routes/route';

new Vue({
    el: '#app',
    router,
    render: h => h(App),
});
