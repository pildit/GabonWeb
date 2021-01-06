import ActionColumn from "./Vue/ActionColumn";

export default (options) => {

    return {
        options: {
            instance: "management_plan",
            store: {
                getter: 'management_plan/management_plans',
                action: 'management_plan/index',
                payload: options
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
            Id: {
                header: "id"
            },
            SpeciesCommonName: {
                header: "th_plan_species",
                sort: false
            },
            GrossVolumeUFG: {
                header: "th_gross_volume_ufg"
            },
            GrossVolumeYear: {
                header: "th_gross_volume_year"
            },
            YieldVolumeYear: {
                header: "th_yield_volume_year"
            },
            CommercialVolumeYear: {
                header: "th_commercial_volume_year"
            },
            Number: {
                header: "th_number"
            },
            Approved: {
                header: 'th_approved',
                forceRender: true,
                render: (row) => {
                    return `<span class="badge badge-${row.Approved ? 'success' : 'danger'}">${row.Approved || false}</span>`
                }
            },
            CreatedAt: {
                header: "th_date",
                render: (row) => `<span>${moment(row.CreatedAt).format('YYYY-MM-DD HH:mm:ss')}</span>`
            },
            actions: {
                header: "th_actions",
                sort: false,
                component: ActionColumn
            }
        }
    }
}
