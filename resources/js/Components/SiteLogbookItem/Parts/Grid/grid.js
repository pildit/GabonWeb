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
                header: "hewing_id",
            },
            aac_name: {
                header: "aac_name",
            },
            ufa: {
                header: "ufa",
            },
            ufg: {
                header: "ufg",
            },
            ObserveAt: {
                header: "date",
                render (row) {
                    return row.ObserveAt.split(' ')[0]
                }
            },
            actions: {
                header: 'actions',
                sort: false,
                css: {
                    textAlign: "right"
                },
                component: ActionColumn
            }

        }
    }
}
