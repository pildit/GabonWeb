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
                header: "id_abattage"
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
            items: {
                header: "tree_id",
                render: (row) => {
                    return row.items.length > 0 ? row.items[0].TreeId : ''
                }
            },
            CreatedAt: {
                header: "date",
                render: (row) => {
                    return row.items.length > 0 ? row.items[0].CreatedAt : row.CreatedAt
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
