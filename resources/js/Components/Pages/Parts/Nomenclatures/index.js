import _ from "lodash";
import Vue from 'vue';
import BoxNomenclature from "./Vue/BoxNomenclature.vue";
import store from "store/store";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {BoxNomenclature},
        data: {
            nomenclatures : [
                {'title' : 'companies', 'link' :  '/nomenclatures/companies', 'resource' : 'companies', 'text' : 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'Permit types', 'link' : '/nomenclatures/permit-types', 'resource' : 'permit-type', text: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'Species', 'link' : '/nomenclatures/species', 'resource' : 'species', text: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'Quality', 'link' : '/nomenclatures/quality', 'resource' : 'quality', text: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'Resource type', 'link' : '/nomenclatures/resource-types', 'resource' : 'resource-type', text: 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'}
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
