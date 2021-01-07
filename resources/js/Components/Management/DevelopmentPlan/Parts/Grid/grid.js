import ActionColumn from "./Vue/ActionColumn";

export default (options) => {

    return {
        options: {
            instance: "development_plan",
            store: {
                getter: 'development_plan/development_plans',
                action: 'development_plan/index',
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
            MinimumExploitableDiameter: {
                header: "th_minimim_exploitable_diameter"
            },
            VolumeTariff: {
                header: "th_volume_tariff"
            },
            Increment: {
                header: "th_increment"
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
