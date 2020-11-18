import Vue from 'vue';
import VueReactiveCookie from 'vue-reactive-cookie';
import VeeValidate from 'vee-validate';
import Notifications from 'vue-notification'
import VueJwt from 'vuejs-jwt';
import Translation from "./Components/Mixins/Translation";
import DateRangePicker from "vue2-daterange-picker"
import store from "store/store"
import config from './Components/_config/index';
import directives from './Components/_config/Directives/index';
import date from './Components/_config/Filters/date';
import SwaggerUI from 'swagger-ui'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';

import Base from './Components/Base';
import Pages from './Components/Pages/Pages';
import User from './Components/User/User';
import Role from './Components/Role/Role';
import Company from './Components/Company/Company';
import PermitType from './Components/PermitType/PermitType';
import Species from './Components/Species/Species';
import Parcel from './Components/Parcel/Parcel';
import Quality from './Components/Quality/Quality';
import ProductType from './Components/ProductType/ProductType';

import DevelopmentUnit from "./Components/Management/DevelopmentUnit/DevelopmentUnit";
import ConstituentPermit from './Components/ConstituentPermit/ConstituentPermit';
import Concession from './Components/Concession/Concession';

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
Vue.use(DateRangePicker);

Vue.mixin(Translation);
Vue.filter('date', date);

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
Gabon.ConstituentPermit = ConstituentPermit;
Gabon.Parcel = Parcel;
Gabon.Quality = Quality;
Gabon.ProductType = ProductType;
Gabon.Concession = Concession;

Gabon.Management = {
    DevelopmentUnit: DevelopmentUnit
}

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
