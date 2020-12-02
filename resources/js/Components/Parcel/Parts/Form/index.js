import _ from 'lodash'
import Vue from 'vue';
import ParcelForm from "./Vue/ParcelForm";
import store from "store/store";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { ParcelForm },
        computed: {
            ...mapGetters('parcels', ['parcel'])
        },
        mounted() {
            if(options.id) {
                let id = options.id;
                store.dispatch('parcels/get', {id});
            }
        }
    };

    return new Vue(_.merge(options, vueOptions));
}
