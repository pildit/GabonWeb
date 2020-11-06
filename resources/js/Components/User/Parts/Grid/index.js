import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import UsersGrid from "./Vue/UsersGrid.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {UsersGrid}
    }

    return new Vue(_.merge(options, vueOptions));
}
