import axios         from 'axios';

export default {
    namespaced: true,
    state: {
        user: {},
        users: [],
        employeeTypes: []
    },
    getters: {
        user(state) {
            return state.user;
        },
        users(state) {
            return state.users;
        },
        employeeTypes(state) {
            return state.employeeTypes;
        }

    },
    mutations: {
        user(state, user) {
            state.user = user;
        },
        users(state, users) {
            state.users = users;
        },
        employeeTypes(state, employeeTypes) {
            state.employeeTypes = employeeTypes;
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
        forgot({}, payload) {
            return axios.post('api/users/forgot', payload)
                .then((response) => response);
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
            return axios.post(`api/users/${payload.id}/approve`, {})
                .then((response) => response);
        },
        delete({}, payload) {
            return axios.delete(`api/users/${payload.id}`)
                .then((response) => response);
        },
        reset({}, payload) {
            return axios.post('api/users/reset', payload.data)
                .then((response) => response);
        },
        update({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/users/${id}`, data)
                .then((response) => response);
        },
        resendConfirmation({}, payload) {
            return axios.post(`api/users/${payload.id}/confirmation`, {})
                .then((response) => response);
        },
        types({commit}) {
            return axios.get(`api/users/types`)
                .then((response) => response.data)
                .then((responseData) => {
                    commit('employeeTypes', responseData.data);
                })
        }
    }
}
