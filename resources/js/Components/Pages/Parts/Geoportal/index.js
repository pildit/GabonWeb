import _ from 'lodash';

/* Map imports */
import Vue from 'vue';
import VueLayers from 'vuelayers'
import 'vuelayers/lib/style.css' // needs css-loader
import GeoportalPage from "./Vue/GeoportalPage.vue";

import store from 'store/store';

/* Load the map */
Vue.use(VueLayers)

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: { GeoportalPage },
        data: {}
    }

    return new Vue(_.merge(options, vueOptions));
}
