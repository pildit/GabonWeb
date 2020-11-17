import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import TranslationGrid from "./Vue/TranslationGrid";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {TranslationGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
