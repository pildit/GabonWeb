import _ from 'lodash'
import Vue from 'vue';
import ManagementUnitForm from "./Vue/ManagementUnitForm";
import store from "store/store";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { ManagementUnitForm }
    };

    return new Vue(_.merge(options, vueOptions));
}
