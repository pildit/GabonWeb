import axios from "axios";

export default {
    namespaced: true,
    state: {
        annual_allowable_cuts: [],
        annual_allowable_cut: {}
    },
    getters: {
        annual_allowable_cuts(state) {
            return state.annual_allowable_cuts;
        },
        annual_allowable_cut(state) {
            return state.annual_allowable_cut;
        }
    },
    mutations: {
        annual_allowable_cuts(state, annual_allowable_cuts) {
            state.annual_allowable_cuts = annual_allowable_cuts;
        },
        annual_allowable_cut(state, annual_allowable_cut) {
            state.annual_allowable_cut = annual_allowable_cut;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/annual_allowable_cuts', {params: payload})
                .then((response) => {
                    commit('annual_allowable_cuts', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/annual_allowable_cuts/${payload.id}`)
                .then((response) => {
                    commit('annual_allowable_cut', response.data.data);
                    return response;
                })
        },

        add({}, payload) {
            return axios.post('api/annual_allowable_cuts', payload)
                .then((response) => response.data)
        },

        update({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/annual_allowable_cuts/${id}`, data)
                .then((response) => response.data);
        },
        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/annual_allowable_cuts/approve/${id}`, data)
                .then((response) => response);
        },

        delete({}, payload) {
            return axios.delete(`api/annual_allowable_cuts/${payload.id}`)
                .then((response) => response);
        },

    }
}
