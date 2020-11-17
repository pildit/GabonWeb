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
                header: "Id"
            },
            Name: {
                header: "Name"
            },
            types: {
                header: "Type",
                render: (row) => {
                    return _.map(row.types, 'Name').join('/')
                }
            },
            Email: {
                header: "Email"
            },
            CreatedAt: {
                header: "Date"
            },
            actions: {
                header: "Actions",
                sort: false,
                css: {
                    textAlign: "right"
                },
                component: ActionColumn
            }
        }
    }
}
