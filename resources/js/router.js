import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import MedicalRecords from './pages/medicalrecords.vue'
import Clinic from './pages/clinic.vue'
import Profile from './pages/profile.vue'
import Appointments from './pages/appointments.vue'
import Dashboard from './pages/dashboard.vue'
import Patients from './pages/patients.vue'
import login from './pages/login.vue'
import register from './pages/register.vue'

const routes = [
    {
        path:  '/medicalrecords',
        component: MedicalRecords,
        name: 'medicalrecords'
    },
    {
        path:  '/clinic',
        component: Clinic,
        name: 'clinic'
    },
    {
        path:  '/profile',
        component: Profile,
        name: 'profile'
    },
    {
        path:  '/appointments',
        component: Appointments,
        name: 'appointments'
    },
    {
        path:  '/dashboard',
        component: Dashboard,
        name: 'dashboard'
    },
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