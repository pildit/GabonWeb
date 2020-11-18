import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "companies",
            store: {
                getter: 'company/companies',
                action: 'company/index'
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
                header: "name"
            },
            types: {
                header: "type",
                forceRender: true,
                render: (row) => {
                    return _.map(row.types, 'Name').join('/')
                }
            },
            Email: {
                header: "email"
            },
            CreatedAt: {
                header: "date"
            },
            actions: {
                header: "actions",
                sort: false,
                css: {
                    textAlign: "right"
                },
                component: ActionColumn
            }
        }
    }
}
