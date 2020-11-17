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
                field: "id"
            }
        },
        columns: {
            Id: {
                header: "id"
            },
            Code: {
                header: "code"
            },
            LatinName: {
                header: "latin_name"
            },
            CommonName: {
                header: "common_name"
            },
            email: {
                header: "email",
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
