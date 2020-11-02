// require('./bootstrap');

import Vue from 'vue';
import VueReactiveCookie from 'vue-reactive-cookie';
import VeeValidate from 'vee-validate';
import VueNotification from "vue-notification";
import config from './Components/_config/index';

import Base from './Components/Base';
import Pages from './Components/Pages/Pages';
import User from './Components/User/User';

Vue.config.devtools = true;
window.Vent         = new Vue;

// Vue.use(VueCookie);
Vue.use(VueReactiveCookie);
Vue.use(VeeValidate, {
    events: 'blur'
});
Vue.use(VueNotification);


let Gabon = window.Gabon || {}

Gabon.Base = Base;
Gabon.Pages = Pages;
Gabon.User = User;

window.Gabon = Gabon;
