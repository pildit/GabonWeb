import Vue           from 'vue';
import Vuex          from 'vuex';
import axios         from 'axios';
import cookie        from 'vue-reactive-cookie';
import user          from './user';
import role         from './role';
import company         from './company';
import permitType         from './permittype';
import species         from './species';
import parcels         from './parcel';
import productType         from './producttype';
import quality         from './quality';
import development_unit from './Management/development_unit';
import development_plan from "./Management/development_plan";
import management_unit from "./Management/management_unit";
import management_plan from "./Management/management_plan";
import constituent_permit         from './constituent_permit';
import concession         from './concession';
import translation from "./translation";
import logbooks from './logbooks';
import sitelogbooks from "./sitelogbooks";
import sitelogbookitems from "./sitelogbookitems";
import permit from "./permit";
import geoportal from './geoportal';

Vue.use(Vuex);
Vue.use(cookie)

export default new Vuex.Store({
    state: {
        translations: {},
        languages: {
            "en" : "us",
            "fr" : "ga"
        },
        lang: Vue.prototype.$cookies.language || 'en',
        menu: [],
        loggedUser: {},
        logged_in: Vue.prototype.$cookies.jwt ? true:false
    },
    getters: {
        translations(state) {
            return state.translations;
        },
        languages(state) {
            return state.languages;
        },
        lang(state) {
            return state.lang;
        },
        menu(state) {
            return state.menu;
        },
        logged_in(state) {
            return state.logged_in;
        },
    },
    mutations: {
        translations(state, translations) {
            state.translations = translations;
        },
        lang(state, lang) {
            state.lang = lang;
        },
        loggedUser(state, user) {
            state.loggedUser = user;
        },
        menu(state, menu) {
            state.menu = menu;
        }
    },
    actions: {
        $fetchTranslations({commit, state}) {
            return axios.get(`/api/translations/dictionary`)
                .then((response) => {
                    commit('translations', response.data['data'][`text_${state.lang}`])
                });
        },
        $fetchMenu({commit, state}) {
            return axios.get('/api/menu')
                .then((response) => {
                    commit('menu', response.data['data'])
                });
        }
    },
    modules: {
        user,
        role,
        company,
        permitType,
        species,
        constituent_permit,
        parcels,
        productType,
        quality,
        development_unit,
        development_plan,
        management_unit,
        management_plan,
        concession,
        translation,
        logbooks,
        concession,
        geoportal,
        sitelogbooks,
        sitelogbookitems,
        permit
    }
});
