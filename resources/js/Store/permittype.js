import axios from 'axios';

export default {
    namespaced: true,
    state: {
        permitTypes: [],
    },
    getters: {
        permittypes(state) {
            return state.permittypes;
        },
    },
    mutations: {
        permittypes(state, permittypes) {
            state.permittypes = permittypes;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/permittypes', {params: payload})
                .then((response) => {
                    commit('permittypes', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/permittypes/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('company', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/permittypes', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/permittypes/${payload.id}`, payload.data)
                .then((response) => response);
        },

    }
}
