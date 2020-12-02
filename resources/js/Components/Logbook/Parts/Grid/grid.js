import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "logbooks",
            store: {
                getter: 'logbooks/logbooks',
                action: 'logbooks/index'
            },
            sort: {
                direction: "asc|desc",
                field: "Approved|Id"
            },
            rowHightlight: {
                'ffe6e6' : (row) => !row.Approved
            }
        },
        columns: {
            Id: {
                header: "th_id",
            },
            'concession.Name': {
                header: "th_concession_name",
                queryKey: "Concession"
            },
            'anuualallowablecut.Name': {
                header: "th_aac_name",
                queryKey: "AnnualAllowableCut"
            },
            Approved: {
                header: 'th_approved',
                forceRender: true,
                render: (row) => {
                    return `<span class="badge badge-${row.Approved ? 'success' : 'danger'}">${row.Approved || false}</span>`
                }
            },
            ObserveAt: {
                header: "th_date"
            },
            actions: {
                header: 'th_actions',
                sort: false,
                css: {
                    textAlign: "right"
                },
                component: ActionColumn
            }

        }
    }
}
