import _ from 'lodash';
import Vue from 'vue';
import store from "store/store";
import ConcessionsForm from "./Vue/ConcessionsForm";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { ConcessionsForm },
        computed: {
            ...mapGetters('concession', ['concession'])
        },
        mounted() {
            store.dispatch('productType/getList');
            if(options.id) {
                let id = options.id;
                store.dispatch('concession/get', {id});
            }
        }
    }

    return new Vue(_.merge(options, vueOptions));
}
