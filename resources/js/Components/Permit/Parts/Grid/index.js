import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import PermitGrid from "./Vue/PermitGrid";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { PermitGrid }
    }

    return new Vue(_.merge(options, vueOptions));
}
