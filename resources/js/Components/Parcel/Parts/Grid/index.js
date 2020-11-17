import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import ItemsGrid from "./Vue/ItemsGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {ItemsGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
