/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
 

axios.get('http://localhost:8000/sanctum/csrf-cookie').then(response => {

    axios.post('http://localhost:8000/api/login').then(function (response) {

        axios.get('http://localhost:8000/api/customers').then(function (response) {
            
            return response.data

        })

    })

});


Vue.use(VueRouter)
 
import App from './components/App';
import Hello from './components/Hello';
import Witaj from './components/Witaj';
import LoremIpsum from './components/LoremIpsum';
import UserCard from './components/UserCard';

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
            props: {
                name: "here",
                email: "should",
                created_at: "be datas",
                role: "from axios"
            }
        },
    ],
});
 
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});