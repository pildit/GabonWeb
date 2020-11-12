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
                header: "Id"
            },
            Name: {
                header: "Name"
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
