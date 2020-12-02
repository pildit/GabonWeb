import axios from 'axios';

export default {
    namespaced: true,
    state: {
        permits: [],
        permit: {},
        permitItems: [],
    },
    getters: {
        permits(state) {
            return state.permits;
        },
        permit(state) {
            return state.permit;
        },
        permitItems(state) {
            return state.permitItems;
        },

    },
    mutations: {
        permits(state, permits) {
            state.permits = permits;
        },
        permit(state, permit) {
            state.permit = permit;
        },
        permitItems(state, permitItems) {
            state.permitItems = permitItems;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/permits', {params: payload})
                .then((response) => {
                    commit('permits', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/permits/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('permit', responseData.data));
        },

        getPermitItems({commit}, payload) {
            return axios.get('api/permit_items/', {
                params: {Permit: payload.id}
            })
                .then((response) => response.data)
                .then((responseData) => commit('permitItems', responseData.data));
        },


        approve({}, payload) {
            return axios.patch(`api/permits/approve/${payload.id}`, payload.data)
                .then((response) => response);
        },

    }
}
