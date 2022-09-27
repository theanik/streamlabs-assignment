import Vue from 'vue'
import Auth from '../utils/Auth.js'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import Dashboard from '../components/pages/Dashboard.vue';
import Plan from '../components/pages/Plan.vue';

const routes = [
    {
        path: '/login',
        component: Login,
        name: "Login"
    },
    {
        path: '/register',
        component: Register,
        name: "Register"
    },
    {
        path: '/',
        component: Dashboard,
        name: "Dashboard",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/plans',
        component: Plan,
        name: "Plan",
        meta: {
            requiresAuth: true
        }
    },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth) ) {
        console.log(Auth.check())
        if (Auth.check()) {
            next()
            return
        } else {
            router.push('/login')
        }
    } else {
        next()
    }
});

export default router
