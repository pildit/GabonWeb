import _ from "lodash";
import Vue from 'vue';
import NavigationMenu from "./Vue/NavigationMenu.vue";
import store from "store/store";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {NavigationMenu},
        data: {},
    }

    return new Vue(_.merge(options, vueOptions));
}
