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
                header: "th_id"
            },
            Value: {
                header: "th_value"
            },
            Description: {
                header: "th_description"
            },
            Email: {
                header: "th_email",
            },
            CreatedAt: {
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
