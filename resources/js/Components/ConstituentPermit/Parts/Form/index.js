import _ from 'lodash';
import Vue from 'vue';
import store from "store/store";
import ConstituentPermitForm from "./Vue/ConstituentPermitForm";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { ConstituentPermitForm }
    }

    return new Vue(_.merge(options, vueOptions));
}
