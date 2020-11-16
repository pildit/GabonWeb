import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "constituentPermits",
            store: {
                getter: 'constituentPermits/constituentPermits',
                action: 'constituentPermits/index'
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
            PermitType: {
                header: "Permit Type"
            },
            PermitNumber: {
                header: "Permit No"
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
