import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import DevelopmentUnitForm from "./Vue/DevelopmentUnitForm.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {DevelopmentUnitForm},
    };

    return new Vue(_.merge(options, vueOptions));
}
