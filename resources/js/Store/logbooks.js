import axios from 'axios';

export default {
    namespaced: true,
    state: {
        logbooks: [],
        logbook: {},
    },
    getters: {
        logbooks(state) {
            return state.logbooks;
        },
        logbook(state) {
            return state.logbook;
        },
    },
    mutations: {
        logbooks(state, logbooks) {
            state.logbooks = logbooks;
        },
        logbook(state, logbook) {
            state.logbook = logbook;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/logbooks', {params: payload})
                .then((response) => {
                    commit('logbooks', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/logbooks/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('logbook', responseData.data));
        },

        update({}, payload) {
            return axios.patch(`api/logbooks/${payload.id}`, payload.data)
                .then((response) => response);
        },

        approve({}, payload) {
            return axios.patch(`api/logbooks/approve/${payload.id}`)
                .then((response) => response);
        },

        approve_item({}, payload) {
            return axios.patch(`api/logbook_items/approve/${payload.id}`)
                .then((response) => response);
        },

    }
}
