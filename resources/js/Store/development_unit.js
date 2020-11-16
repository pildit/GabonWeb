import axios from "axios";

export default {
    namespaced: true,
    state: {
        development_units: []
    },
    getters: {
        development_units(state) {
            return state.development_units;
        }
    },
    mutations: {
        development_units(state, development_units) {
            state.development_units = development_units;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/development_units', {params: payload})
                .then((response) => {
                    commit('development_units', response.data.data);
                    return response
                });
        }
    }
}
