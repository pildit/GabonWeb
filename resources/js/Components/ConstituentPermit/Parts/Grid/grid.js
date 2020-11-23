import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "constituent_permit",
            store: {
                getter: 'constituent_permit/items',
                action: 'constituent_permit/index'
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
            "PermitTypeObj.Abbreviation" : {
                header: "Permit Type"
            },
            PermitNumber: {
                header: "Permit No"
            },
            Approved: {
                header: "Approved"
            },
            Email: {
                header: "Email",
            },
            CreatedAt: {
                header: "Date",
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
