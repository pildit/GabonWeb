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
                header: "th_id"
            },
            name: {
                header: "th_role"
            },
            type: {
                header: "th_role_type"
            },
            created_at: {
                header: "th_created_at",
            },
            actions: {
                header: 'th_actions',
                sort: false,
                css: {
                  textAlign: "right"
                },
                component: ActionColumn
            }

        }
    }
}
