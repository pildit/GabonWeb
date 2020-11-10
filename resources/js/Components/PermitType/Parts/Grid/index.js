import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import PermitTypesGrid from "./Vue/PermitTypesGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {PermitTypesGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
