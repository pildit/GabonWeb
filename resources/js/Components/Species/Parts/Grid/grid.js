import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "species",
            store: {
                getter: 'species/species',
                action: 'species/index'
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
            Code: {
                header: "Code"
            },
            LatinName: {
                header: "LatinName"
            },
            CommonName: {
                header: "CommonName"
            },
            email: {
                header: "Email",
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
