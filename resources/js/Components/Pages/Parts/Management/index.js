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
            management : [
                {'title' : 'development_unit_title', 'link' :  '/management/development-units', 'resource' : 'development_units', 'text' : 'development_unit_description'},
                {'title' : 'management_unit_title', 'link' :  '/management/management-units', 'resource' : 'management_units', 'text' : 'development_unit_description'},
                {'title' : 'aac_unit_title', 'link' :  '/management/aac', 'resource' : 'annual_allowable_cuts', 'text' : 'development_unit_description'},
            ]
        },
        computed: {
            ...mapGetters('user', ['user'])
        },
    }
    return new Vue(_.merge(options, vueOptions));
}