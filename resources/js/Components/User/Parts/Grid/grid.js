import User from "components/User/User";

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
            status: {
                header: "Status",
                forceRender: true,
                render: (row) => {
                    return `<span>${User.getStatusLabel(row.status)}</span>`
                }
            },
            created_at: {
                header: "Date"
            }

        }
    }
}
