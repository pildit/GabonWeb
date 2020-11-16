import axios from 'axios';

export default {
    namespaced: true,
    state: {
        constituentPermits: [],
    },
    getters: {
        constituentPermits(state) {
            return state.constituentPermits;
        },
    },
    mutations: {
        constituentPermits(state, constituentPermits) {
            state.constituentPermits = constituentPermits;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/constituent_permits', {params: payload})
                .then((response) => {
                    commit('parcels', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/constituent_permits/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('parcel', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/constituent_permits', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/constituent_permits/${payload.id}`, payload.data)
                .then((response) => response);
        },

        listSearch({}, payload) {
            return axios.get(`api/constituent_permits/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
