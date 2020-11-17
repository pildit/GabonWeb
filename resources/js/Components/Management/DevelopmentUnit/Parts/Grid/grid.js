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
                field: "Id"
            }
        },
        columns: {
            Id: {
                header: "Id"
            },
            Name: {
                header: "Name",
                render: (row) => `<strong>${row.Name}</strong>`
            },
            ConcessionName: {
                header: "Concession"
            },
            plans: {
                header: "Plan Id",
                render: (row) => {
                    return _.map(row.plans, 'Id').join('/')
                }
            },
            CreatedAt: {
                header: "Date",
                render: (row) => `<span>${moment(row.CreatedAt).format('YYYY-MM-DD HH:mm:ss')}</span>`
            },
            actions: {
                header: "Actions",
                sort: false,
                component: ActionColumn
            }
        }
    }
}
