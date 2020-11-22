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
                header: "id"
            },
            Name: {
                header: "name"
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
