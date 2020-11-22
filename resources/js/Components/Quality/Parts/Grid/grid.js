import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "quality",
            store: {
                getter: 'quality/quality',
                action: 'quality/index'
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
            Value: {
                header: "value"
            },
            Description: {
                header: "description"
            },
            Email: {
                header: "email",
            },
            CreatedAt: {
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
