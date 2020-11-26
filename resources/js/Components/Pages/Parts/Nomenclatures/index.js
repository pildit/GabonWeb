import _ from "lodash";
import Vue from 'vue';
import VueCard from "components/Common/VueCard.vue";
import store from "store/store";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {VueCard},
        data: {
            nomenclatures : [
                {'title' : 'companies', 'link' :  '/nomenclatures/companies', 'resource' : 'companies', 'text' : 'companies_unit_description', 'permission': 'companies.view'},
                {'title' : 'permit_types', 'link' : '/nomenclatures/permit-types', 'resource' : 'permit-type', text: 'permit_types_unit_description', 'permission': 'concession.view'},
                {'title' : 'species', 'link' : '/nomenclatures/species', 'resource' : 'species', text: 'species_unit_description', 'permission': 'species.view'},
                {'title' : 'quality', 'link' : '/nomenclatures/quality', 'resource' : 'quality', text: 'quality_unit_description', 'permission': 'quality.view'},
                {'title' : 'resource_type', 'link' : '/nomenclatures/product-type', 'resource' : 'resource-type', text: 'product_type_unit_description', 'permission': 'product-types.view'}
            ]
        },
        computed: {
        ...mapGetters('user', ['user'])
        },
        created() {
        }
    }
    return new Vue(_.merge(options, vueOptions));
}
