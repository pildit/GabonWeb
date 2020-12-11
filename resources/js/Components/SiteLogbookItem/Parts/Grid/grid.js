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
            Id: {
                header: "th_id",
            },
            HewingId: {
                header: "th_id_abattage"
            },
            Length: {
                header: "th_length"
            },
            AverageDiameter: {
                header: "th_avg_diameter"
            },
            Volume: {
                header: "th_volume"
            },
            SpeciesLatinName: {
                header: "th_species",
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
