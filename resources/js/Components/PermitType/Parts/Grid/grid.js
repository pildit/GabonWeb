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
                header: "id"
            },
            Name: {
                header: "name"
            },
            Abbreviation: {
                header: "abbreviation"
            },
            email: {
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
