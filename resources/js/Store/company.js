import axios from 'axios';

export default {
    namespaced: true,
    state: {
        companies: [],
        company: {},
        types: [
            {Id: 1, Name: 'concessionaire'},
            {Id: 2, Name: 'transporter'},
            {Id: 3, Name: 'client'}
        ]
    },
    getters: {
        companies(state) {
            return state.companies;
        },
        company(state) {
            return state.company;
        },
        types(state) {
            return state.types;
        }
    },
    mutations: {
        companies(state, companies) {
            state.companies = companies;
        },
        company(state, company) {
            state.company = company;
        },
        types(state, types) {
            return state.types = types;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/companies', {params: payload})
                .then((response) => {
                    commit('companies', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/companies/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('company', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/companies', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/companies/${payload.id}`, payload.data)
                .then((response) => response);
        },

        listSearch({}, payload) {
            return axios.get(`api/companies/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
