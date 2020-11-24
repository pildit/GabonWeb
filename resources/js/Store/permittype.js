import axios from 'axios';

export default {
    namespaced: true,
    state: {
        permitTypes: [],
    },
    getters: {
        permitTypes(state) {
            return state.permitTypes;
        },
    },
    mutations: {
        permitTypes(state, permitTypes) {
            state.permitTypes = permitTypes;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/permit_types', {params: payload})
                .then((response) => {
                    commit('permitTypes', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/permit_types/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('company', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/permit_types', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/permit_types/${payload.id}`, payload.data)
                .then((response) => response);
        },

        listSearch({}, payload) {
            return axios.get(`api/permit_types/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        },

    }
}
