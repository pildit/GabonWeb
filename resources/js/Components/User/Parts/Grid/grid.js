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
            }
        },
        columns: {
            id: {
                header: "id"
            },
            lastname: {
                header: "name"
            },
            firstname: {
                header: "first_name"
            },
            email: {
                header: "email"
            },
            company_name: {
                header: "company"
            },
            status: {
                header: "status",
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
                    textAlign: "right"
                },
                component: ActionColumn
            }
        }
    }
}
