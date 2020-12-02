import _ from "lodash";
import Vue from 'vue';
import ForgotPasswordForm from "./Vue/ForgotPasswordForm.vue";
import store from "store/store";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {ForgotPasswordForm},
        data: {},
    }

    return new Vue(_.merge(options, vueOptions));
}
