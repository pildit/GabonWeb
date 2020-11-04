import axios from 'axios';

export default {
    namespaced: true,
    state: {
        roles: [],
    },
    getters: {
        roles(state) {
            return state.roles;
        }
    },
    muttators: {
        roles(state, roles) {
            state.roles = roles;
        }
    },
    actions: {
        get({commit}, payload) {
            return axios.get('api/roles', {params: payload})
                .then((response) => {
                    return response;
                });
        }
    }
}
