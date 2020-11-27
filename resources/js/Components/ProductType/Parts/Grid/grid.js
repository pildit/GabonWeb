import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "product-types",
            store: {
                getter: 'productType/productTypes',
                action: 'productType/index'
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
            Name: {
                header: "th_name"
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
