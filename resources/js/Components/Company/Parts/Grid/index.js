import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import CompaniesGrid from "./Vue/CompaniesGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {CompaniesGrid},
        mounted() {
            store.dispatch('company/listCompanyTypes');
        }
    }

    return new Vue(_.merge(options, vueOptions));
}
