import axios from 'axios';

export default {
    namespaced: true,
    state: {
        parcels: [],
        parcel: {}
    },
    getters: {
        parcels(state) {
            return state.parcels;
        },
        parcel(state) {
            return state.parcel
        }
    },
    mutations: {
        parcels(state, parcels) {
            state.parcels = parcels;
        },
        parcel(state, parcel) {
            state.parcel = parcel;
        },
        types(state, types) {
            return state.types = types;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get('api/parcels', {params: payload})
                .then((response) => {
                    commit('parcels', response.data.data);
                    return response
                });
        },

        get({commit}, payload) {
            return axios.get(`api/parcels/${payload.id}`)
                .then((response) => response.data)
                .then((responseData) => commit('parcel', responseData.data));
        },

        add({}, payload) {
            return axios.post('api/parcels', payload)
                .then((response) => response)
        },

        update({}, payload) {
            return axios.patch(`api/parcels/${payload.id}`, payload.data)
                .then((response) => response);
        },
        approve({}, payload) {
            return axios.patch(`api/parcels/approve/${payload.id}`, payload.data)
                .then((response) => response);
        },
        listSearch({}, payload) {
            return axios.get(`api/parcels/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
