import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '../store';


Vue.use(VueRouter)

const ifNotAuthenticated = (to, from, next) => {
    if (!store.getters.checkAuth) {
        next();
        return;
    }
    next("/");
};

const ifAuthenticated = (to, from, next) => {
    if (store.getters.checkAuth) {
        next();
        return;
    }
    next("/");
};

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home.vue')
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../views/Login.vue'),
        beforeEnter: ifNotAuthenticated
    },
    {
        path: '/registration',
        name: 'Registration',
        component: () => import('../views/Registration.vue')
    },
    {
        path: '/profile',
        name: 'Profile',
        component: () => import('../views/Profile.vue')
    },
    {
        path: '/books',
        name: 'Books',
        component: () => import('../views/Book.vue')
    },
    {
        path: '/authors',
        name: 'Authors',
        component: () => import('../views/Author.vue')
    },
];

export default new VueRouter({
    mode: 'hash',
    //mode: 'history',
    base: '/',
    routes
});

