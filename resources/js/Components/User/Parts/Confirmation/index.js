import _ from "lodash";
import Vue from 'vue';
import AccountConfirmation from "./Vue/AccountConfirmation.vue";
import store from "store/store";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {AccountConfirmation},
        data: {},
    }

    return new Vue(_.merge(options, vueOptions));
}
