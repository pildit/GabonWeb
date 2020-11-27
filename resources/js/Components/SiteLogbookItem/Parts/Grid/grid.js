import ActionColumn from "./Vue/ActionColumn";
import store from "store/store"

export default (options) => {
    return {
        options: {
            instance: "sitelogbookitems",
            store: {
                getter: 'sitelogbookitems/siteLogbookItems',
                action: 'sitelogbookitems/index'
            },
            sort: {
                direction: "desc",
                field: "Id"
            }
        },
        columns: {
            HewingId: {
                header: "th_log_id",
            },
            aac_name: {
                header: "th_aac_name",
            },
            ufa: {
                header: "th_ufa",
            },
            ufg: {
                header: "th_ufg",
            },
            ObserveAt: {
                header: "th_date",
                render: (row) => `<span>${moment(row.ObserveAt).format('YYYY-MM-DD')}</span>`
            },
            actions: {
                header: 'the_actions',
                sort: false,
                css: {
                    textAlign: "right"
                },
                component: ActionColumn
            }

        }
    }
}
