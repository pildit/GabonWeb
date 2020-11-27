import ActionColumn from "./Vue/ActionColumn";

export default (options) => {
    return {
        options: {
            instance: "permit",
            store: {
                getter: 'permit/permits',
                action: 'permit/index'
            },
            sort: {
                direction: "desc",
                field: "Id"
            }
        },
        columns: {
            PermitNo: {
                header: "th_id"
            },
            'annualallowablecut.Name': {
                header: "th_aac_name",
            },
            'transportercompany.Name': {
                header: "th_company_name",
            },
            LicensePlate: {
                header: "th_license_plate"
            },
            ObserveAt: {
                header: "th_date",
                render: (row) => `<span>${moment(row.ObserveAt).format('YYYY-MM-DD')}</span>`
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
