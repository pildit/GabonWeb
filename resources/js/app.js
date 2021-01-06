import Vue from 'vue';
import VueReactiveCookie from 'vue-reactive-cookie';
import VeeValidate from 'vee-validate';
import Notifications from 'vue-notification'
import VueJwt from 'vuejs-jwt';
import DateRangePicker from "vue2-daterange-picker"
import Translate from "./Components/Mixins/Translation";
import store from "store/store"
import config from './Components/_config/index';
import directives from './Components/_config/Directives/index';
import date from './Components/_config/Filters/date';
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';
import VueSweetalert2 from "vue-sweetalert2";

import Base from './Components/Base';
import Pages from './Components/Pages/Pages';
import Geomap from './Components/Geomap/Geomap';
import User from './Components/User/User';
import Role from './Components/Role/Role';
import Company from './Components/Company/Company';
import PermitType from './Components/PermitType/PermitType';
import Species from './Components/Species/Species';
import Parcel from './Components/Parcel/Parcel';
import Quality from './Components/Quality/Quality';
import ProductType from './Components/ProductType/ProductType';
import Logbook from './Components/Logbook/Logbook';
import Permit from "./Components/Permit/Permit";
import DevelopmentUnit from "./Components/Management/DevelopmentUnit/DevelopmentUnit";
import ConstituentPermit from './Components/ConstituentPermit/ConstituentPermit';
import Concession from './Components/Concession/Concession';
import Translation from './Components/Translations/Translation'
import DevelopmentPlan from "./Components/Management/DevelopmentPlan/DevelopmentPlan";
import ManagementUnit from "./Components/Management/ManagementUnit/ManagementUnit";
import ManagementPlan from "./Components/Management/ManagementPlan/ManagementPlan";
import AAC from "./Components/Management/AAC/AAC";
import AACOperationPlan from "./Components/Management/AAC/AACOperationPlan";

import SiteLogbook from "./Components/SiteLogbook/SiteLogbook";
import SiteLogbookItem from "./Components/SiteLogbookItem/SiteLogbookItem";

Vue.config.devtools = true;
window.Vent = new Vue;

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
Vue.use(VueSweetalert2);

Vue.filter('date', date);
Vue.mixin(Translate);

new Vue({
    el: '#notification'
})


let Gabon = window.Gabon || {}

Gabon.Base = Base;
Gabon.Pages = Pages;
Gabon.Geomap = Geomap;
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
Gabon.Logbook = Logbook;
Gabon.SiteLogbook = SiteLogbook;
Gabon.SiteLogbookItem = SiteLogbookItem;
Gabon.Permit = Permit;

Gabon.Management = {
    DevelopmentUnit: DevelopmentUnit,
    DevelopmentPlan: DevelopmentPlan,
    ManagementUnit: ManagementUnit,
    ManagementPlan: ManagementPlan,
    AAC: AAC,
    AACOperationPlan: AACOperationPlan
}

Gabon.Translation = Translation;

window.Gabon = Gabon;
if (Vue.$jwt.hasToken()) {
    store.commit('loggedUser', Vue.$jwt.decode()['data']);
}

Vue.prototype.$diffObj = function (object, base) {
    function changes(object, base) {
        return _.transform(object, function (result, value, key) {
            if (!_.isEqual(value, base[key])) {
                result[key] = (_.isObject(value) && _.isObject(base[key])) ? changes(value, base[key]) : value;
            }
        });
    }
    return changes(object, base);
}

// Webpage loading layer
Vue.prototype.$showLoading = function () {
    document.querySelector('#page-loader').classList.add('page-loader')
}

Vue.prototype.$hideLoading = function () {
    document.querySelector('#page-loader').classList.remove('page-loader')
}
Vue.prototype.$showLoading();
