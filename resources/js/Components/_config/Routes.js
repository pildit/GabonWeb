export default {
    users: {
        index: `/users`,
        edit: `/users/{id}/edit`
    },

    development_units: {
        index: '/management/development-units',
        create: '/management/development-units/create',
        edit: '/management/development-units/{id}/edit',
        plans: '/management/development-units/{id}/plans'
    },

    management_units: {
        index: '/management/management-units',
        create: '/management/management-units/create',
        edit: '/management/management-units/{id}/edit',
        plans: '/management/management-units/{id}/plans'
    },

    aac: {
        index: '/management/aac',
        create: '/management/aac/create',
        edit: '/management/aac/{id}/edit',
    },

    parcels: {
        index: "/management/parcels",
        create: "/management/parcels/create",
        edit: "/management/parcels/{id}/edit",
    },

    constituent_permits: {
        index: '/concessions/constituent-permits',
        create: '/concessions/constituent-permits/create',
        edit: '/concessions/constituent-permits/{id}/edit',
    },

    sitelogbooks: {
        items: '/sitelogbooks/{id}/items',
    },

    concessions: {
        index: '/concessions/list',
        create: '/concessions/create',
        edit: '/concessions/{id}/edit'
    }
}
