import _ from "lodash";
import Vue from 'vue';
import BoxResource from "../../../Common/Box/BoxResource.vue";
import store from "store/store";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {BoxResource},
        data: {
            concessions : [
                {'title' : 'parcels', 'link' :  '/concessions/parcels', 'resource' : 'parcels', 'text' : 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'constituent_permits', 'link' :  '/concessions/constituent-permits', 'resource' : 'constituent_permits', 'text' : 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
                {'title' : 'concessions', 'link' :  '/concessions/concessions', 'resource' : 'concessions', 'text' : 'Some quick example text to build on the card title and make up the bulk of the card\'s content.'},
            ]
        },
        computed: {
            ...mapGetters('user', ['user'])
        },
        created() {
            // TODO : check permissions
        }
    }
    return new Vue(_.merge(options, vueOptions));
}
