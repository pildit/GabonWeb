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
                direction: "desc",
                field: "Id"
            }
        },
        columns: {
            Id: {
                header: "id"
            },
            Name: {
                header: 'th_aac_name'
            },
            "management_unit.Name": {
                header: "th_ufg"
            },
            management_plans: {
                header: "th_plan_id",
                render: (row) => {
                    return _.map(row.management_plans, 'Number').join('/')
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
