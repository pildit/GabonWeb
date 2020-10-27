// require('./bootstrap');

import Vue from 'vue';
// import VueCookie from 'vue-cookie';
import VueReactiveCookie from 'vue-reactive-cookie';

import Base from './Components/Base';
import Pages from './Components/Pages/Pages';
import User from './Components/User/User';

Vue.config.devtools = true;
window.Vent         = new Vue;

// Vue.use(VueCookie);
Vue.use(VueReactiveCookie);


let Gabon = window.Gabon || {}

Gabon.Base = Base;
Gabon.Pages = Pages;
Gabon.User = User;

window.Gabon = Gabon;
window.baseUrl = 'http://localhost:8000';
