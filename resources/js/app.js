/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import router from './router'
import store from './store'
import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css'

Vue.use(VueTelInput)

import vuetify from './vuetify';

import animateCss from 'animate.css';
Vue.use(animateCss);

import VueSweetalert2 from 'vue-sweetalert2';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2); 

import common from './common'
Vue.mixin(common);

Vue.component('mainapp', require('./components/mainapp.vue').default);
Vue.component('app2', require('./components/app2.vue').default);


const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store
});
