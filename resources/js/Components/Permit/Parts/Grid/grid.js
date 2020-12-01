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
                direction: "asc|desc",
                field: "Approved|Id"
            },
            rowHightlight: {
                'ffe6e6' : (row) => !row.Approved
            }
        },
        columns: {
            PermitNo: {
                header: "th_id"
            },
            'annualallowablecut.Name': {
                header: "th_aac_name",
                queryKey: 'AnnualAllowableCut'
            },
            'transportercompany.Name': {
                header: "th_company_name",
                queryKey: 'TransporterCompany'
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
