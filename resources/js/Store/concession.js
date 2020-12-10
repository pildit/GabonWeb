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

        get({commit}, payload) {
            return axios.get(`api/concessions/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('concession', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/concessions', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/concessions/${payload.id}`, payload.data)
                .then((response) => response);
        },

        delete({}, payload) {
            return axios.delete(`api/concessions/${payload.id}`)
                .then((response) => response);
        },

        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/concessions/approve/${id}`, data)
                .then((response) => response);
        },

        listSearch({}, payload) {
            return axios.get(`api/concessions/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
