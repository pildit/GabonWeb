import axios from 'axios';

export default {
    namespaced: true,
    state: {
        species: [],
    },
    getters: {
        species(state) {
            return state.species;
        },
    },
    mutations: {
        species(state, species) {
            state.species = species;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/species', {params: payload})
                .then((response) => {
                    commit('species', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/species/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('species', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/species', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/species/${payload.id}`, payload.data)
                .then((response) => response);
        },
        listSearch({}, payload) {
            return axios.get(`api/species/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }

    }
}
