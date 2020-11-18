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
                header: "Id"
            },
            Value: {
                header: "Value"
            },
            Description: {
                header: "Description"
            },
            Email: {
                header: "Email",
            },
            CreatedAt: {
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