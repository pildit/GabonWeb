import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import UserForm from "./Vue/UserForm.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {UserForm},
        mounted() {

        }
    }

    return new Vue(_.merge(options, vueOptions));
}
