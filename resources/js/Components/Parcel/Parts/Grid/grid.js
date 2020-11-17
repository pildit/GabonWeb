import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "parcels",
            store: {
                getter: 'parcels/parcels',
                action: 'parcels/index'
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
                header: "Abbreviation"
            },
            Approved: {
                header: "Approved"
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
