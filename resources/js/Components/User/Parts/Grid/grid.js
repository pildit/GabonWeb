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
        },
        columns: {
            id: {
                header: "Id"
            },
            lastname: {
                header: "Name"
            },
            firstname: {
                header: "First Name"
            },
            email: {
                header: "Email"
            },
            company_name: {
                header: "Company"
            },
            status: {
                header: "Status",
                forceRender: true,
                render: (row) => {
                    return `<span>${User.getStatusLabel(row.status)}</span>`
                }
            },
            created_at: {
                header: "Date"
            },
            actions: {
                header: "Actions",
                sort: false,
                css: {
                    textAlign: "right"
                },
                component: ActionColumn
            }
        }
    }
}
