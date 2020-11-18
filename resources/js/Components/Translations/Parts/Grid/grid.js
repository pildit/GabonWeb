import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "translations",
            store: {
                getter: 'translation/translations',
                action: 'translation/index'
            },
        },
        columns: {
            text_key: {
                header: "key"
            },
            text_us: {
                header: "english"
            },
            text_ga: {
                header: "french"
            },
            mobile: {
                header: "mobile",
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
