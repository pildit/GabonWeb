import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import SiteLogbookGrid from "./Vue/SiteLogbookGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {SiteLogbookGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
