import Vue           from 'vue';
import Vuex          from 'vuex';
import axios         from 'axios';
import cookie        from 'vue-reactive-cookie';

Vue.use(Vuex);
Vue.use(cookie)

export default new Vuex.Store({
    state: {
        translations: {},
        languages: {
            "en" : "us",
            "fr" : "ga"
        },
        lang: Vue.prototype.$cookies.language || 'en'
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
        }
    },
    mutations: {
        translations(state, translations) {
            state.translations = translations;
        },
        lang(state, lang) {
            state.lang = lang;
        }
    },
    actions: {
        $fetchTranslations({commit, state}) {
            return axios.get(`/api/translations/dictionary`)
                .then((response) => {
                    commit('translations', response.data['data'][`text_${state.lang}`])
                });
        }
    },
    modules: {
    }
});
