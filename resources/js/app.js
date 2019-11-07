require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import VueAxios from 'vue-axios';
import axios from 'axios';
import App from './App.vue';
Vue.use(VueAxios, axios);

import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/ja';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI, { locale });

import HomeComponent from './components/HomeComponent.vue';
import IndexComponent from './components/IndexComponent.vue'
import InfiniteLoading from 'vue-infinite-loading'
Vue.use(InfiniteLoading);

const routes = [
 {
     name: 'home',
     path: '/',
     component: HomeComponent
 },
 {
     name: 'index',
     path: '/app_index',
     component: IndexComponent
 },
];

const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');