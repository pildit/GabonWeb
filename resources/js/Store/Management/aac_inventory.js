import axios from 'axios';

export default {
    namespaced: true,
    state: {
        annual_allowable_cut_inventories: [],
    },
    getters: {
        annual_allowable_cut_inventories(state) {
            return state.annual_allowable_cut_inventories;
        }
    },
    mutations: {
        annual_allowable_cut_inventories(state, data) {
            return state.annual_allowable_cut_inventories = data;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/annual_allowable_cut_inventory', {params: payload})
                .then((response) => {
                    commit('annual_allowable_cut_inventories', response.data.data);
                    return response
                });
        },
        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/annual_allowable_cut_inventory/approve/${id}`, data)
                .then((response) => response);
        }
    }
}
