import axios from 'axios';

export default {
    namespaced: true,
    state: {
        roles: [],
        role: {},
        permissions: []
    },
    getters: {
        roles(state) {
            return state.roles;
        },
        role(state) {
            return state.role;
        },
        permissions(state) {
            return state.permissions;
        }
    },
    mutations: {
        roles(state, roles) {
            state.roles = roles;
        },
        role(state, role) {
            state.role = role;
        },
        permissions(state, permissions) {
            return state.permissions = permissions;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/roles', {params: payload})
                .then((response) => {
                    commit('roles', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/roles/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('role', responseData.data));
        },

        add({}, payload) {
             return axios.post('api/roles', payload)
                 .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/roles/${payload.id}`, payload.data)
                .then((response) => response);
        },

        roles({commit}) {
            return axios.get('api/roles/list')
                .then((response) => response.data.data)
                .then((roles) => commit('roles', roles));
        },

        permissions({commit}) {
            return axios.get('api/permissions')
                .then((response) => response.data.data)
                .then((permissions) => commit('permissions', permissions));
        }
    }
}
