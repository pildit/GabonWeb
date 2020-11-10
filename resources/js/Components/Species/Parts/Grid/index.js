import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import SpeciesGrid from "./Vue/SpeciesGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {SpeciesGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
