import _ from 'lodash';
import Vue from 'vue';
import store from "store/store";
import Grid from "./Common/Grid/Grid";
import Router from "./Router";

class Base {

    static getTranslations()
    {
        return store.dispatch('$fetchTranslations').then(() => store.state.translations);
    }

    static renderTable(selector, grid, options = {}) {
        let vueOptions = {
            store,
            el: selector,
            components: {Grid},
            data: { grid }
        };

        return new Vue(_.merge(options, vueOptions));
    }

    static render(selector, options = {})
    {
        let components = this.getComponents();

        return components[selector](`#${selector}`, options);
    }

    static buildRoute(name, params = {}) {
        return Router.build(name, params);
    }
}

export default Base;
