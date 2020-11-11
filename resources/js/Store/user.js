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
                    return response;
                });
        },
        login({}, payload) {
            return axios.post('api/users/login', payload)
                .then((response) => response)
        },
        register({}, payload) {
            return axios.post('api/users/register', payload)
                .then((response) => response)
        },
        verify({}, payload) {
            return axios.post('api/users/verify', payload)
                .then((response) => response);
        },
        add({}, payload) {
            return axios.post('api/users/registerAdmin', payload)
                .then((response) => response)
        },
        approve({}, payload) {
            return axios.post(`api/users/${payload.id}/approve`, {}).then((response) => response);
        },
        update({}, payload) {
            let id = payload.id;
            delete payload.id;
            return axios.patch(`api/users/${id}`, payload)
                .then((response) => response);
        }
    }
}
