import _ from "lodash";
import Vue from 'vue';
import UserDetails from "./Vue/UserDetails.vue";

export default (selector, options) => {
    let vueOptions = {
        el: selector,
        components: {UserDetails},
        data: {

        }
    }

    return new Vue(_.merge(options, vueOptions));
}
