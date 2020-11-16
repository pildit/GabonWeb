import axios from 'axios';

export default {
    namespaced: true,
    state: {
        quality: [],
    },
    getters: {
        quality(state) {
            return state.quality;
        },
    },
    mutations: {
        quality(state, quality) {
            state.quality = quality;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/quality', {params: payload})
                .then((response) => {
                    commit('quality', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/quality/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('quality', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/quality', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/quality/${payload.id}`, payload.data)
                .then((response) => response);
        },

    }
}
