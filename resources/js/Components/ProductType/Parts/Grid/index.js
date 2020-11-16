import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import ProductTypesGrid from "./Vue/ProductTypeGrid.vue";


export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {ProductTypesGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
