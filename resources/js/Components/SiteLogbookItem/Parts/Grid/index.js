import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import SiteLogbookItemGrid from "./Vue/SiteLogbookItemGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {SiteLogbookItemGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
