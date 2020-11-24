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
                header: "id"
            },
            "permit_type.Abbreviation" : {
                header: "permit_type"
            },
            PermitNumber: {
                header: "permit_number"
            },
            Email: {
                header: "email",
            },
            CreatedAt: {
                header: "date",
                render: (row) => `<span>${moment(row.CreatedAt).format('YYYY-MM-DD HH:mm:ss')}</span>`
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
