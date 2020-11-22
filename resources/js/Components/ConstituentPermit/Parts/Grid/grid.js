import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "constituentPermit",
            store: {
                getter: 'constituentPermit/items',
                action: 'constituentPermit/index'
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
            "PermitTypeObj.Abbreviation" : {
                header: "permit_type"
            },
            PermitNumber: {
                header: "permit_no"
            },
            Approved: {
                header: "approved"
            },
            Email: {
                header: "email",
            },
            CreatedAt: {
                header: "date",
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
