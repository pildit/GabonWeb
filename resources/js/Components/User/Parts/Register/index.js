import _ from "lodash";
import Vue from 'vue';
import RegisterForm from "./Vue/RegisterForm.vue";
import store from "store/store";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {RegisterForm},
        data: {},
    }

    return new Vue(_.merge(options, vueOptions));
}
