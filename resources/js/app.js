require('./bootstrap');

window.Vue = require('vue').default;
axios.defaults.headers.post['Accept'] = 'application/json';

import VueRouter from 'vue-router'
Vue.use(VueRouter)

Vue.component('base-component', require('./components/baseComponent.vue').default);

import VueSimplemde from 'vue-simplemde'
Vue.component('vue-simplemde', VueSimplemde)

import User from './Helpers/User';
window._User = new User();

import Exception from './Helpers/Exception';
window._Exception = new Exception();

window.EventBus = new Vue();

import { routes } from './router.js';
import Vue from 'vue';
const router = new VueRouter({
    routes,
    mode: 'history'
  })

const app = new Vue({
    el: '#app',
    router,
});
