import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import Patients from './pages/patients.vue'
import login from './pages/login.vue'
import register from './pages/register.vue'

const routes = [
    {
        path:  '/patients',
        component: Patients,
        name: 'patients'
    },
    {
        path:  '/login',
        component: login,
        name: 'login'
    },
    {
        path:  '/register',
        component: register,
        name: 'register'
    },
]

export default new Router ({
    mode: 'history',
    routes,
})