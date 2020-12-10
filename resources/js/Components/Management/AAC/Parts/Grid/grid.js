import ActionColumn from "./Vue/ActionColumn.vue";

export default (options) => {
    return {
        options: {
            instance: "annual_allowable_cut",
            store: {
                getter: 'aac/annual_allowable_cuts',
                action: 'aac/index'
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
                header: "id"
            },
            AacId: {
                header: "acc_id"
            },
            Name: {
                header: 'th_aac_name'
            },
            ManagementUnitName: {
                header: "th_ufg",
            },
            management_plans: {
                header: "th_plan_id",
                sort: false,
                render: (row) => {
                    return _.map(row.management_plans, 'Number').join('/')
                }
            },
            Email: {
                header: "th_email",
            },
            Approved: {
                header: 'th_approved',
                forceRender: true,
                render: (row) => {
                    return `<span class="badge badge-${row.Approved ? 'success' : 'danger'}">${row.Approved || false}</span>`
                }
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
