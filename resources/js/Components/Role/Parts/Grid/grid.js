import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "roles",
            store: {
                getter: 'role/roles',
                action: 'role/index'
            },
        },
        columns: {
            id: {
                header: "Id"
            },
            name: {
                header: "Role"
            },
            type: {
                header: "Type"
            },
            created_at: {
                header: "Created At",
            },
            actions: {
                header: 'Actions',
                sort: false,
                css: {
                  textAlign: "right"
                },
                component: ActionColumn
            }

        }
    }
}
