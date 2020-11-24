import axios from "axios";

export default {
    namespaced: true,
    state: {
        concessions: [],
        concession: {}
    },
    getters: {
        concessions(state) {
            return state.concessions;
        },
        concession(state) {
            return state.concession;
        }
    },
    mutations: {
        concessions(state, items) {
            state.concessions = items;
        },
        concession(state, data) {
            state.concession = data;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/concessions', {params: payload})
                .then((response) => {
                    commit('concessions', response.data.data);
                    return response
                });
        },

        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/concessions/approve/${id}`, data)
                .then((response) => response.data);
        },

        listSearch({}, payload) {
            return axios.get(`api/concessions/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
