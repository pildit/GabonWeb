export default {
    users: {
        index: `/users`,
        edit: `/users/{id}/edit`
    },

    development_units: {
        index: '/management/development-units',
        create: '/management/development-units/create',
        edit: '/management/development-units/{id}/edit'
    },

    management_units: {
        index: '/management/management-units',
        create: '/management/management-units/create',
        edit: '/management/management-units/{id}/edit',
    }
}
