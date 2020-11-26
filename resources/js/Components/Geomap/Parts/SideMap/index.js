import _ from "lodash";
import Vue from 'vue';
import SideMap from "./Vue/SideMap.vue";
import store from "store/store";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { SideMap },
    }
    return new Vue(_.merge(options, vueOptions));
}
