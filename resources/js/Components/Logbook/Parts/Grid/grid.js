import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "logbooks",
            store: {
                getter: 'logbooks/logbooks',
                action: 'logbooks/index'
            },
            sort: {
                direction: "desc",
                field: "Id"
            }
        },
        columns: {
            Id: {
                header: "logbook_id",
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
            ObservedAt: {
                header: "date"
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
