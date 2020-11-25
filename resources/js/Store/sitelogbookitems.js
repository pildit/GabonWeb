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
            return axios.get(`api/site_logbooks/${payload.Logbook}`)
                .then((response) => {
                    var siteLogbook = response.data.data,
                        items = response.data.data.items
                    items.forEach((item) => {
                        item.aac_name = siteLogbook.anuualallowablecut.Name
                        item.ufa = siteLogbook.developmentunit.Name
                        item.ufg = siteLogbook.managementunit.Name
                        item.ReportNote = siteLogbook.ReportNote
                        item.concession_name = siteLogbook.concession.Name
                        item.Localization = siteLogbook.Localization
                        item.ReportNote = siteLogbook.ReportNote
                    })
                    commit('siteLogbookItems', items);
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

        /**
         * TODO Approve pe backend. Oricum las asta aici.
         * @param payload
         * @returns {Promise<AxiosResponse<any>>}
         */
        approve({}, payload) {
            return axios.patch(`api/site_logbook_items/approve/${payload.id}`)
                .then((response) => response);
        },

    }
}
