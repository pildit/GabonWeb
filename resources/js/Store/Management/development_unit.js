import axios from "axios";

export default {
    namespaced: true,
    state: {
        development_units: [],
        development_unit: {}
    },
    getters: {
        development_units(state) {
            return state.development_units;
        },
        development_unit(state) {
            return state.development_unit;
        }
    },
    mutations: {
        development_units(state, development_units) {
            state.development_units = development_units;
        },
        development_unit(state, development_unit) {
            state.development_unit = development_unit;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/development_units', {params: payload})
                .then((response) => {
                    commit('development_units', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/development_units/${payload.id}`)
                .then((response) => {
                    commit('development_unit', response.data.data);
                    return response;
                })
        },

        add({}, payload) {
            return axios.post('api/development_units', payload)
                .then((response) => response.data)
        },

        update({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/development_units/${id}`, data)
                .then((response) => response.data);
        },
        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/development_units/approve/${id}`, data)
                .then((response) => response);
        },
        listSearch({}, payload) {
            return axios.get(`api/development_units/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
