import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "permit-types",
            store: {
                getter: 'permitType/permitTypes',
                action: 'permitType/index'
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
            Abbreviation: {
                header: "Abbreviation"
            },
            email: {
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
