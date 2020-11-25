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
                header: "id_permit"
            },
            annualallowablecut: {
                header: "aac_name",
                render (row) {
                    return row.annualallowablecut.Name
                }
            },
            TransporterCompany: {
                header: "company_name",
                render (row) {
                    return row.transportercompany.Name
                }
            },
            LicensePlate: {
                header: "license_plate"
            },
            ObserveAt: {
                header: "date",
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
