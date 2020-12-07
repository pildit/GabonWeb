import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "development_unit",
            store: {
                getter: 'development_unit/development_units',
                action: 'development_unit/index'
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
            Number: {
                header: 'th_dev_unit_id'
            },
            Name: {
                header: "th_dev_unit_name"
            },
            ConcessionName: {
                header: "th_concession_name",
                queryKey: "Concession"
            },
            plans: {
                header: "th_plan_id",
                sort: false,
                render: (row) => {
                    return _.map(row.plans, 'Id').join('/')
                }
            },
            Email: {
                header: "th_email"
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
