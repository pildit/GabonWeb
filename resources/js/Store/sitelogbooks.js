import axios from 'axios';

export default {
    namespaced: true,
    state: {
        siteLogbooks: [],
        siteLogbook: {},
        siteLogbookItemLogs: []
    },
    getters: {
        siteLogbooks(state) {
            return state.siteLogbooks;
        },
        siteLogbook(state) {
            return state.siteLogbook;
        },
        siteLogbookItemLogs(state) {
            return state.siteLogbookItemLogs;
        },
    },
    mutations: {
        siteLogbooks(state, siteLogbooks) {
            state.siteLogbooks = siteLogbooks;
        },
        siteLogbook(state, siteLogbook) {
            state.siteLogbook = siteLogbook;
        },
        siteLogbookItemLogs(state, siteLogbookItemLogs) {
            state.siteLogbookItemLogs = siteLogbookItemLogs;
        },
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

        update({}, payload) {
            return axios.patch(`api/site_logbooks/${payload.id}`, payload.data)
                .then((response) => response);
        },

        getItemLogs ({commit}, payload) {
            return axios.get('api/site_logbook_logs/', {params:
                    { SiteLogbookItem: payload.id}
                })
                .then((response) => response.data)
                .then((responseData) => commit('siteLogbookItemLogs', responseData.data));
        },

        /**
         * TODO Approve pe backend. Oricum las asta aici.
         * @param payload
         * @returns {Promise<AxiosResponse<any>>}
         */
        approve({}, payload) {
            return axios.patch(`api/site_logbooks/approve/${payload.id}`)
                .then((response) => response);
        },

        approve_item({}, payload) {
            return axios.patch(`api/site_logbook_items/approve/${payload.id}`)
                .then((response) => response);
        },

    }
}
