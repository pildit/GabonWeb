import _ from 'lodash'
import Vue from 'vue';
import AacForm from "./Vue/AacForm";
import store from "store/store";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { AacForm },
        computed: {
            ...mapGetters('aac', ['annual_allowable_cut'])
        },
        mounted() {
            store.dispatch('productType/getList');
            if(options.id) {
                let id = options.id;
                store.dispatch('aac/get', {id});
            }
        }
    };

    return new Vue(_.merge(options, vueOptions));
}
