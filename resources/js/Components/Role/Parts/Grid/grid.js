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
                header: "id"
            },
            name: {
                header: "role"
            },
            type: {
                header: "type"
            },
            created_at: {
                header: "created_at",
            },
            actions: {
                header: 'actions',
                sort: false,
                css: {
                  textAlign: "right"
                },
                component: ActionColumn
            }

        }
    }
}
