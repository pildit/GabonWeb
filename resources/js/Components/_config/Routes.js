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
    },

    aac: {
        index: '/management/aac',
        create: '/management/aac/create',
        edit: '/management/aac/{id}/edit',
    },

    constituent_permits: {
        index: '/concessions/constituent-permits',
        create: '/concessions/constituent-permits/create',
        edit: '/concessions/constituent-permits/{id}/edit',
    },

    concessions: {
        index: '/concessions/list',
        create: '/concessions/create',
        edit: '/concessions/{id}/edit'
    }
}
