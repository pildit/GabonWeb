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
                header: "id"
            },
            Name: {
                header: "abbreviation"
            },
            Approved: {
                header: "approved"
            },
            Email: {
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
