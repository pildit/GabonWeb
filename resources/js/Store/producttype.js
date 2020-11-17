import axios from 'axios';

export default {
    namespaced: true,
    state: {
        productTypes: [],
    },
    getters: {
        productTypes(state) {
            return state.productTypes;
        },
    },
    mutations: {
        productTypes(state, productTypes) {
            state.productTypes = productTypes;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/product_type', {params: payload})
                .then((response) => {
                    commit('productTypes', response.data.data);
                    return response
                });
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

        update({}, payload) {
            return axios.patch(`api/product_type/${payload.id}`, payload.data)
                .then((response) => response);
        },

    }
}
