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
                direction: "desc",
                field: "CreatedAt"
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
                header: "th_dev_unit_name",
            },
            ConcessionName: {
                header: "th_concession_name"
            },
            plans: {
                header: "th_plan_id",
                render: (row) => {
                    return _.map(row.plans, 'Id').join('/')
                }
            },
            Email: {
                header: "th_email"
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
