import axios from 'axios';

export default {
    namespaced: true,
    state: {
        siteLogbooks: [],
        siteLogbook: {}
    },
    getters: {
        siteLogbooks(state) {
            return state.siteLogbooks;
        },
        siteLogbook(state) {
            return state.siteLogbook;
        }
    },
    mutations: {
        siteLogbooks(state, siteLogbooks) {
            state.siteLogbooks = siteLogbooks;
        },
        siteLogbook(state, siteLogbook) {
            state.siteLogbook = siteLogbook;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/site_logbooks', {params: payload})
                .then((response) => {
                    commit('siteLogbooks', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/site_logbooks/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('siteLogbook', responseData.data));
        },

        /**
         * TODO Approve pe backend. Oricum las asta aici.
         * @param payload
         * @returns {Promise<AxiosResponse<any>>}
         */
        approve({}, payload) {
            return axios.patch(`api/site_logbooks/approve/${payload.id}`, payload.data)
                .then((response) => response);
        },

    }
}
