import _ from "lodash";
import Vue from 'vue';
import store from "store/store";
import DevelopmentUnitForm from "./Vue/DevelopmentUnitForm.vue";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {DevelopmentUnitForm},
        computed: {
            ...mapGetters('development_unit', ['development_unit'])
        },
        mounted() {
            if(options.id) {
                let id = options.id;
                store.dispatch('development_unit/get', {id});
            }
        }
    };

    return new Vue(_.merge(options, vueOptions));
}
