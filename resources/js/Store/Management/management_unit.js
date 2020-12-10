import axios from "axios";

export default {
    namespaced: true,
    state: {
        management_units: [],
        management_unit: {}
    },
    getters: {
        management_units(state) {
            return state.management_units;
        },
        management_unit(state) {
            return state.management_unit;
        }
    },
    mutations: {
        management_units(state, management_units) {
            state.management_units = management_units;
        },
        management_unit(state, management_unit) {
            state.management_unit = management_unit;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/management_units', {params: payload})
                .then((response) => {
                    commit('management_units', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/management_units/${payload.id}`)
                .then((response) => {
                    commit('management_unit', response.data.data);
                    return response;
                })
        },

        add({}, payload) {
            return axios.post('api/management_units', payload)
                .then((response) => response.data)
        },

        update({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/management_units/${id}`, data)
                .then((response) => response.data);
        },
        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/management_units/approve/${id}`, data)
                .then((response) => response);
        },
        delete({}, payload) {
            return axios.delete(`api/management_units/${payload.id}`)
                .then((response) => response);
        },

        listSearch({}, payload) {
            return axios.get(`api/management_units/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }

    }
}
