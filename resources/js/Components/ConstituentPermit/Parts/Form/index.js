import _ from 'lodash';
import Vue from 'vue';
import store from "store/store";
import ConstituentPermitForm from "./Vue/ConstituentPermitForm";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { ConstituentPermitForm },
        computed: {
            ...mapGetters('constituent_permit', ['constituent_permit'])
        },
        mounted() {
            if(options.id) {
                let id = options.id;
                store.dispatch('constituent_permit/get', {id});
            }
        }
    }

    return new Vue(_.merge(options, vueOptions));
}
