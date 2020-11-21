import _ from 'lodash'
import Vue from 'vue';
import ManagementUnitForm from "./Vue/ManagementUnitForm";
import store from "store/store";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { ManagementUnitForm },
        computed: {
            ...mapGetters('management_unit', ['management_unit'])
        },
        mounted() {
            if(options.id) {
                let id = options.id;
                store.dispatch('management_unit/get', {id});
            }
        }
    };

    return new Vue(_.merge(options, vueOptions));
}
