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
            store.dispatch('productType/getList');
            if(options.id) {
                let id = options.id;
                this.$refs.development_unit_form.isCreatedFormType = false;
                this.$refs.development_unit_form.isReady = false;
                store.dispatch('development_unit/get', {id}).then(() => this.$refs.development_unit_form.isReady = true);
            }
        }
    };

    return new Vue(_.merge(options, vueOptions));
}
