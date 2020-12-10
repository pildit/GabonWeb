import axios from 'axios';

export default {
    namespaced: true,
    state: {
        productTypes: [],
        productTypeList: [],
    },
    getters: {
        productTypes(state) {
            return state.productTypes;
        },
        productTypeList(state) {
            return state.productTypeList;
        }
    },
    mutations: {
        productTypes(state, productTypes) {
            state.productTypes = productTypes;
        },
        productTypeList(state, types) {
            return state.productTypeList = types;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/product_type', {params: payload})
                .then((response) => {
                    commit('productTypes', response.data.data);
                    return response
                });
        },

        getList({commit}, payload) {
            return axios.get(`api/product_type/list`)
                .then((response) => response.data)
                .then((response) => {
                    commit('productTypeList', response.data);
                })
        },

        get({commit}, payload) {
            return axios.get(`api/product_type/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('product-type', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/product_type', payload)
                .then((response) => response)
        },

        delete({}, payload) {
            return axios.delete(`api/product_type/${payload.id}`)
                .then((response) => response);
        },

        update({}, payload) {
            return axios.patch(`api/product_type/${payload.id}`, payload.data)
                .then((response) => response);
        },

    }
}
