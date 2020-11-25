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
                {'title' : 'companies', 'link' :  '/nomenclatures/companies', 'resource' : 'companies', 'text' : 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'permit_types', 'link' : '/nomenclatures/permit-types', 'resource' : 'permit-type', text: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'species', 'link' : '/nomenclatures/species', 'resource' : 'species', text: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'quality', 'link' : '/nomenclatures/quality', 'resource' : 'quality', text: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'resource_type', 'link' : '/nomenclatures/product-type', 'resource' : 'resource-type', text: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'}
            ]
        },
        computed: {
        ...mapGetters('user', ['user'])
        },
        created() {
/*
            this.nomenclatures = this.nomenclatures.filter(item => {
                return this.user.permissions.includes(item.resource);
            });

 */
        }
    }
    return new Vue(_.merge(options, vueOptions));
}
