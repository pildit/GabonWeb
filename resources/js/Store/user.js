import axios         from 'axios';

export default {
    namespaced: true,
    state: {
        user: window.user,
        users: [],
    },
    getters: {
        user(state) {
            return state.user;
        },
        users(state) {
            return state.users;
        }
    },
    mutations: {
        user(state, user) {
            state.user = user;
        },
        users(state, users) {
            state.users = users;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/users', {params: payload})
                .then((response) => {
                    commit('users', response.data.data);
                    return response
                });
        },
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
