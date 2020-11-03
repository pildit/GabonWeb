// require('./bootstrap');

import Vue from 'vue';
import VueReactiveCookie from 'vue-reactive-cookie';
import VeeValidate from 'vee-validate';
import Notifications from 'vue-notification'
import VueJwt from 'vuejs-jwt';
import store from "store/store"
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
Vue.use(Notifications);
Vue.use(VueJwt, {
    signKey: process.env.MIX_JWT_SECRET,
    keyName: 'jwt',
    storage: 'cookie'
})

new Vue({
    el: '#notification'
})


let Gabon = window.Gabon || {}

Gabon.Base = Base;
Gabon.Pages = Pages;
Gabon.User = User;

window.Gabon = Gabon;
if(Vue.$jwt.hasToken()) {
    store.commit('user/user', Vue.$jwt.decode()['data']);
}
