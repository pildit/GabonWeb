import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "permit-types",
            store: {
                getter: 'permitType/permitTypes',
                action: 'permitType/index'
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
            Abbreviation: {
                header: "th_abbreviation"
            },
            Email: {
                header: "th_email",
            },
            CreatedAt: {
                header: "th_date",
            },
            actions: {
                header: 'th_actions',
                sort: false,
                css: {
                  textAlign: "right"
                },
                component: ActionColumn
            }

        }
    }
}
