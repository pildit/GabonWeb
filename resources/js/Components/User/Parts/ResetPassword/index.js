import _ from "lodash";
import Vue from 'vue';
import ResetPassword from "./Vue/ResetPassword.vue";
import store from "store/store";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {ResetPassword},
        data: {},
    }

    return new Vue(_.merge(options, vueOptions));
}
