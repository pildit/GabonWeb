import _ from "lodash";
import Vue from 'vue';
import VueCardMenu from "../../../Common/VueCardMenu";
import store from "store/store";
import {mapGetters} from "vuex";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {VueCardMenu},
        data: {
            concessions : [
                {'title' : 'constituent_permits', 'link' :  '/concessions/constituent-permits', 'resource' : 'constituent_permits', 'text' : 'constituent_permits_unit_description', 'permission': 'constituent-permit.view'},
                {'title' : 'concessions', 'link' :  '/concessions/list', 'resource' : 'concessions', 'text' : 'concessions_unit_description', 'permission': 'concession.view'},
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
