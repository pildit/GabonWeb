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
                direction: "desc",
                field: "Id"
            }
        },
        columns: {
            Id: {
                header: "site_logbook_id",
            },
            ReportNo: {
                header: "report_number",
            },
            Company: {
                header: "company",
                render: (row) => {
                    return row.company.Name
                }
            },
            Concession: {
                header: "concession_name",
                render: (row) => {
                    return row.concession.Name
                }
            },
            anuualallowablecut: {
                header: "aac_name",
                render: (row) => {
                    return row.anuualallowablecut.Name
                }
            },
            ObserveAt: {
                header: "date",
                render (row) {
                    return row.ObserveAt.split(' ')[0]
                }
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
