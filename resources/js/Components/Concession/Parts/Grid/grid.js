import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "concessions",
            store: {
                getter: 'concession/concessions',
                action: 'concession/index'
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
            Number: {
                header: 'concession_no'
            },
            'constituent_permit.PermitNumber': {
                header: 'constituent_permit'
            },
            Name: {
                header: 'concession_name'
            },
            Email: {
                header: 'email'
            },
            CreatedAt: {
                header: 'date',
                render: (row) => `<span>${moment(row.CreatedAt).format('YYYY-MM-DD HH:mm:ss')}</span>`
            },
            actions: {
                header: 'actions',
                sort: false,
                component: ActionColumn
            }

        }
    }
}
