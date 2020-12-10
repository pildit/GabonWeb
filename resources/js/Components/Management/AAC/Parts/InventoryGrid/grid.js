import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "annual_allowable_cut_inventories",
            store: {
                getter: 'aac_inventory/annual_allowable_cut_inventories',
                action: 'aac_inventory/index'
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
                header: 'th_id'
            },
            MobileId: {
                header: 'th_mobile_id'
            },
            AnnualAllowableCutName: {
                header: 'th_aac_name',
            },
            Approved: {
                header: 'th_approved',
                forceRender: true,
                render: (row) => {
                    return `<span class="badge badge-${row.Approved ? 'success' : 'danger'}">${row.Approved || false}</span>`
                }
            },
            Email: {
                header: "th_email",
                queryKey: "User"
            },
            CreatedAt: {
                header: "th_date",
                render: (row) => `<span>${moment(row.CreatedAt).format('YYYY-MM-DD HH:mm:ss')}</span>`
            },
            actions: {
                header: "th_actions",
                sort: false,
                component: ActionColumn
            }
        }
    }
}
