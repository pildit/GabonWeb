import Vue           from 'vue';
import Vuex          from 'vuex';
import axios         from 'axios';
import cookie        from 'vue-reactive-cookie';
import user          from './user';
import role         from './role';

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
        role
    }
});
