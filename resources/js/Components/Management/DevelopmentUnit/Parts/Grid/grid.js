export default (options) => {
    return {
        options: {
            instance: "development_unit",
            store: {
                getter: 'development_unit/development_units',
                action: 'development_unit/index'
            },
            sort: {
                direction: "desc",
                field: "Id"
            }
        },
        columns: {
            Id: {
                header: "Id"
            },
            Name: {
                header: "Name"
            },
            Concession: {
                header: "Concession"
            },
            plans: {
                header: "Plan Id"
            },
            CreatedAt: {
                header: "Date"
            }
        }
    }
}
