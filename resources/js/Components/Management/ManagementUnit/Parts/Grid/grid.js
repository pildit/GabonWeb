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
                    return _.map(row.plans, 'Number').join('/')
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
