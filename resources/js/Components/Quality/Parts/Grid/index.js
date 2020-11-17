import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import QualityGrid from "./Vue/QualityGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {QualityGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
