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

import 'bootstrap/dist/css/bootstrap.css'

import animateCss from 'animate.css';
Vue.use(animateCss);

import Swal from 'sweetalert2'

import 'sweetalert2/src/sweetalert2.scss'
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
    })
window.Toast = Toast;

import vuetify from './vuetify';

import VueGoodTablePlugin from 'vue-good-table';
// import the styles
import 'vue-good-table/dist/vue-good-table.css'
Vue.use(VueGoodTablePlugin);



import vueCalendar from 'vue2-simple-calendar';

Vue.use(vueCalendar, {
  // configuration goes here.
});


import common from './common'
Vue.mixin(common);

Vue.component('mainapp', require('./components/mainapp.vue').default);
Vue.component('app2', require('./components/app2.vue').default);

Vue.filter('formatDate', function (value) {
    let d = new Date( value );
    let date = d.toDateString();
    return date
  })
const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store
});
