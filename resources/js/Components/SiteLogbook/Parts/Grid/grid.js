import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "sitelogbooks",
            store: {
                getter: 'sitelogbooks/siteLogbooks',
                action: 'sitelogbooks/index'
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
                header: "th_id",
            },
            ReportNo: {
                header: "th_report_number",
            },
            Company: {
                header: "th_company",
                render: (row) => {
                    return (row.company) ? row.company.Name : ''
                }
            },
            Concession: {
                header: "th_concession_name",
                render: (row) => {
                    return (row.concession) ? row.concession.Name : ''
                }
            },
            AnnualAllowableCut: {
                header: "th_aac_name",
                render: (row) => {
                    return (row.anuualallowablecut) ? row.anuualallowablecut.Name : ''
                }
            },
            Approved: {
                header: 'th_approved',
                forceRender: true,
                render: (row) => {
                    return `<span class="badge badge-${row.Approved ? 'success' : 'danger'}">${row.Approved || false}</span>`
                }
            },
            ObserveAt: {
                header: "th_date",
                render: (row) => `<span>${moment(row.ObserveAt).format('YYYY-MM-DD')}</span>`
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
