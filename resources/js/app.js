
import Vue from 'vue';
import VueReactiveCookie from 'vue-reactive-cookie';
import VeeValidate from 'vee-validate';
import Notifications from 'vue-notification'
import VueJwt from 'vuejs-jwt';
import Translation from "./Components/Mixins/Translation";
import store from "store/store"
import config from './Components/_config/index';
import directives from './Components/_config/Directives/index';
import SwaggerUI from 'swagger-ui'

import Base from './Components/Base';
import Pages from './Components/Pages/Pages';
import User from './Components/User/User';
import Role from './Components/Role/Role';
import Company from './Components/Company/Company';
import PermitType from './Components/PermitType/PermitType';
import Species from './Components/Species/Species';
import Quality from './Components/Quality/Quality';
import ProductType from './Components/ProductType/ProductType';

Vue.config.devtools = true;
window.Vent         = new Vue;

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

Vue.mixin(Translation);

new Vue({
    el: '#notification'
})


let Gabon = window.Gabon || {}

Gabon.Base = Base;
Gabon.Pages = Pages;
Gabon.User = User;
Gabon.Role = Role;
Gabon.Company = Company;
Gabon.PermitType = PermitType;
Gabon.Species = Species;
Gabon.Quality = Quality;
Gabon.ProductType = ProductType;

window.Gabon = Gabon;
if(Vue.$jwt.hasToken()) {
    store.commit('loggedUser', Vue.$jwt.decode()['data']);
}

Vue.prototype.$diffObj = function (object, base) {
    function changes(object, base) {
        return _.transform(object, function(result, value, key) {
            if (!_.isEqual(value, base[key])) {
                result[key] = (_.isObject(value) && _.isObject(base[key])) ? changes(value, base[key]) : value;
            }
        });
    }
    return changes(object, base);
}
Vue.prototype.$showLoading = function() {
    document.querySelector('#page-loader').classList.add('page-loader')
}

Vue.prototype.$hideLoading = function () {
    document.querySelector('#page-loader').classList.remove('page-loader')
}
Vue.prototype.$showLoading();
