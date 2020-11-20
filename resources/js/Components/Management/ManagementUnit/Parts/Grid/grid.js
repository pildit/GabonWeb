import ActionColumn from "./Vue/ActionColumn.vue";

export default (options) => {
    return {
        options: {
            instance: "management_unit",
            store: {
                getter: 'management_unit/management_units',
                action: 'management_unit/index'
            },
            sort: {
                direction: "desc",
                field: "Id"
            }
        },
        columns: {
            Id: {
                header: "id"
            },
            Number: {
                header: 'th_management_unit_id'
            },
            Name: {
                header: "th_management_unit_name",
            },
            'development_unit.Name' : {
                header: "th_dev_unit_name"
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
