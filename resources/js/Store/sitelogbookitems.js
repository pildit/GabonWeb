import axios from 'axios';

export default {
    namespaced: true,
    state: {
        siteLogbookItem: {},
        siteLogbookItems: [],
        itemLogs: []
    },
    getters: {
        siteLogbookItem(state) {
            return state.siteLogbookItem;
        },
        siteLogbookItems(state) {
            return state.siteLogbookItems;
        },
        itemLogs(state) {
            return state.itemLogs;
        },
    },
    mutations: {
        siteLogbookItem(state, siteLogbookItem) {
            state.siteLogbookItem = siteLogbookItem;
        },
        siteLogbookItems(state, siteLogbookItems) {
            state.siteLogbookItems = siteLogbookItems;
        },
        itemLogs(state, itemLogs) {
            state.itemLogs = itemLogs;
        },
    },
    actions: {
        index({commit}, payload) {
            return axios.get(`api/site_logbook_items/${payload.id}`,{params: payload})
                .then((response) => {
                    commit('siteLogbookItems', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get('api/site_logbook_logs/', {params:
                    { SiteLogbookItem: payload.id}
                })
                .then((response) => response.data)
                .then((responseData) => commit('itemLogs', responseData.data));
        },

        approve({}, payload) {
            return axios.patch(`api/site_logbook_items/approve/${payload.id}`, payload.data)
                .then((response) => response);
        },
        approveLog({}, payload) {
            return axios.patch(`api/site_logbook_logs/approve/${payload.id}`, payload.data)
                .then((response) => response);
        },

        delete({}, payload) {
            return axios.delete(`api/site_logbook_items/${payload.id}`)
                .then((response) => response);
        },

        deleteItem({}, payload) {
            return axios.delete(`api/site_logbook_logs/${payload.id}`)
                .then((response) => response);
        },

    }
}
