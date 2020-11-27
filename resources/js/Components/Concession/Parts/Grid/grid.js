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
                direction: "asc|desc",
                field: "Approved|Id"
            },
            rowHightlight: {
                'ffe6e6' : (row) => !row.Approved
            }
        },
        columns: {
            Id: {
                header: "th_id"
            },
            Number: {
                header: 'th_concession_no'
            },
            'constituent_permit.PermitNumber': {
                header: 'th_constituent_permit'
            },
            Name: {
                header: 'th_concession_name'
            },
            Email: {
                header: 'th_email'
            },
            Approved: {
                header: "th_approved",
                forceRender: true,
                render: (row) => {
                    return `<span class="badge badge-${row.Approved ? 'success' : 'danger'}">${row.Approved || false}</span>`
                }
            },
            CreatedAt: {
                header: 'th_date',
                render: (row) => `<span>${moment(row.CreatedAt).format('YYYY-MM-DD HH:mm:ss')}</span>`
            },
            actions: {
                header: 'th_actions',
                sort: false,
                component: ActionColumn
            }

        }
    }
}
