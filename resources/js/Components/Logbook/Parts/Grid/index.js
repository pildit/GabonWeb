import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import LogbookGrid from "./Vue/LogbookGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {LogbookGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
