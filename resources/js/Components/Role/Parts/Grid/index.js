import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import RolesGrid from "./Vue/RolesGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {RolesGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
