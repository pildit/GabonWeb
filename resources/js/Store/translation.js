import axios from 'axios';

export default {
    namespaced: true,
    state: {
        translations: [],
        translation: {},
    },
    getters: {
        translations(state) {
            return state.translations;
        },
        translation(state) {
            return state.translation;
        },
        ttt(state, test) {
            console.log(state);
            console.log(test);
        }
    },
    mutations: {
        translations(state, translations) {
            state.translations = translations;
        },
        translation(state, translation) {
            state.translation = translation;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/translations', {params: payload})
                .then((response) => {
                    commit('translations', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/translations/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('translation', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/translations', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.put(`api/translations/${payload.id}`, payload.data)
                .then((response) => response);
        },

        delete({}, payload) {
            return axios.delete(`api/translations/${payload.id}`)
                .then((response) => response);
        },
    }
}
