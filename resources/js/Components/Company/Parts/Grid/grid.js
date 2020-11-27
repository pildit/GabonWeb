import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "companies",
            store: {
                getter: 'company/companies',
                action: 'company/index'
            },
            sort: {
                direction: "desc",
                field: "Id"
            }
        },
        columns: {
            Id: {
                header: "th_id"
            },
            Name: {
                header: "th_name"
            },
            types: {
                header: "th_company_type",
                forceRender: true,
                render: (row) => {
                    return _.map(row.types, 'Name').join('/')
                }
            },
            "Email" : {
                header: "th_email"
            },
            TradeRegister:  {
                header: "th_trade_register",
                css: {
                    minWidth: '160px'
                }
            },
            CreatedAt: {
                header: "th_date"
            },
            actions: {
                header: "th_actions",
                sort: false,
                css: {
                    textAlign: "right"
                },
                component: ActionColumn
            }
        }
    }
}
