import User from "components/User/User";
import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "users",
            store: {
                getter: 'user/users',
                action: 'user/index'
            },
            sort: {
                direction: "asc",
                field: "status"
            },
            rowHightlight: {
                'ffbb3354' : (row) => ['0','1'].includes(row.status)
            }
        },
        columns: {
            id: {
                header: "id"
            },
            lastname: {
                header: "name",
                css:{
                    maxWidth: '200px'
                },
            },
            firstname: {
                header: "first_name"
            },
            email: {
                header: "email"
            },
            company_name: {
                header: "company",
                css: {
                    width: '120px'
                }
            },
            status: {
                header: "status",
                css:{
                    width: '100px'
                },
                render: (row) => {
                    return `<span class="badge ${User.getStatusClass(row.status)}">${User.getStatusLabel(row.status)}</span>`
                }
            },
            created_at: {
                header: "date"
            },
            actions: {
                header: "actions",
                sort: false,
                css: {
                    width: '110px',
                    textAlign: "right"
                },
                component: ActionColumn
            }
        }
    }
}
