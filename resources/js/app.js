/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
 
Vue.use(VueRouter)
 
import App from './components/App';
import Hello from './components/Hello.vue';
import Witaj from './components/Witaj.vue';
import LoremIpsum from './components/LoremIpsum.vue';
import UserCard from './components/UserCard.vue';
 
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
        },
        {
            path: '/witaj',
            name: 'witaj',
            component: Witaj,
        },
        {
            path: '/LoremIpsum',
            name: 'LoremIpsum',
            component: LoremIpsum,
        },
        {
            path: '/UserCard',
            name: 'UserCard',
            component: UserCard,
        },
    ],
});
 
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});