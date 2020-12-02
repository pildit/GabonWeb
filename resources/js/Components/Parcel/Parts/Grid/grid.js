import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "parcels",
            store: {
                getter: 'parcels/parcels',
                action: 'parcels/index'
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
                header: "th_id"
            },
            Name: {
                header: "th_abbreviation"
            },
            Email: {
                header: "th_email",
                queryKey: "User"
            },
            Approved: {
                header: "th_approved",
                forceRender: true,
                render: (row) => {
                    return `<span class="badge badge-${row.Approved ? 'success' : 'danger'}">${row.Approved || false}</span>`
                }
            },
            CreatedAt: {
                header: "th_created_at",
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
