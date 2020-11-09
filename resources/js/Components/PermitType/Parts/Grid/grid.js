import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "permit-types",
            store: {
                getter: 'permit-type/permit-types',
                action: 'permit-type/index'
            },
        },
        columns: {
            id: {
                header: "Id"
            },
            name: {
                header: "Permit Type"
            },
            abbreviation: {
                header: "Abbreviation"
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
