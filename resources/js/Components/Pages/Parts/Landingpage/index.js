import _ from 'lodash';
import Vue from 'vue';
import store from 'store/store';
import IntroInfo from "./Vue/IntroInfo.vue";
import MainPage from "./Vue/MainPage.vue";

export default (selector, options) => {
    let vueOptions = {
        store,
        el: selector,
        components: {IntroInfo, MainPage},
        data: {}
    }

    return new Vue(_.merge(options, vueOptions));
}
