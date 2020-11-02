// require('./bootstrap');

import Vue from 'vue';
import VueReactiveCookie from 'vue-reactive-cookie';
import VeeValidate from 'vee-validate';
import Notifications from 'vue-notification'
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

new Vue({
    el: '#notification'
})

Vue.prototype.$setErrorsFromResponse = function(errorResponse) {
    // only allow this function to be run if the validator exists
    if(!this.hasOwnProperty('$validator')) {
        return;
    }

    // clear errors
    this.$validator.errors.clear();

    // check if errors exist
    if(!errorResponse.hasOwnProperty('errors')) {
        return;
    }

    let errorFields = Object.keys(errorResponse.errors);

    // insert laravel errors
    errorFields.map(field => {
        let errorString = errorResponse.errors[field].join(', ');
        this.$validator.errors.add(field, errorString);
    });
};

let Gabon = window.Gabon || {}

Gabon.Base = Base;
Gabon.Pages = Pages;
Gabon.User = User;

window.Gabon = Gabon;
