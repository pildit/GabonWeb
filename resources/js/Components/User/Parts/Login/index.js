import _ from "lodash";
import Vue from 'vue';
import LoginForm from "./Vue/LoginForm.vue";
import store from "store/store";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {LoginForm},
        data: {},
    }

    return new Vue(_.merge(options, vueOptions));
}
