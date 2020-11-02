import axios         from 'axios';

export default {
    namespaced: true,
    state: {
        user: window.user,
    },
    getters: {
        user(state) {
            return state.user;
        },
    },
    mutations: {
        user(state, user) {
            state.user = user;
        },
    },
    actions: {
        login({commit}, payload) {
            return axios.post('api/users/login', payload)
                .then((response) => {
                    return response;
                })
        },
        register({commit}, payload) {
            return axios.post('api/users/register', payload)
                .then((response) => {
                    return response;
                })
        },
        verify({commit}, payload) {
            return axios.post('api/users/verify', payload)
                .then((response) => {
                    return response;
                });
        }
    }
}
