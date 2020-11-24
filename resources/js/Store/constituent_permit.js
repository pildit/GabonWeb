import axios from 'axios';

export default {
    namespaced: true,
    state: {
        items: [],
        item: {},
        types: []
    },
    getters: {
        items(state) {
            return state.items;
        },
        types(state) {
            return state.types;
        }
    },
    mutations: {
        items(state, items) {
            state.items = items;
        },
        types(state, types) {
            state.types = types;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/constituent_permits', {params: payload})
                .then((response) => {
                    commit('items', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/constituent_permits/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('item', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/constituent_permits', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/constituent_permits/${payload.id}`, payload.data)
                .then((response) => response);
        },

        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/constituent_permits/approve/${id}`, data)
                .then((response) => response.data);
        },

        listSearch({}, payload) {
            return axios.get(`api/constituent_permits/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        },
    }
}
