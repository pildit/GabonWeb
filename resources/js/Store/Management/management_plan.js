import axios from 'axios';

export default {
    namespaced: true,
    state: {
        management_plans: []
    },
    getters: {
        management_plans(state) {
            return state.management_plans;
        }
    },
    mutations: {
        management_plans(state, management_plans) {
            state.management_plans = management_plans;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get(`api/management_plans/${payload.id}`,{params: payload})
                .then((response) => {
                    commit('management_plans', response.data.data);
                    return response;
                })
        },
        add({}, payload) {
            return axios.post('api/management_plans', payload)
                .then((response) => response.data)
        },
        update({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/management_plans/${id}`, data)
                .then((response) => response.data);
        },
        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/management_plans/approve/${id}`, data)
                .then((response) => response);
        },
        delete({}, payload) {
            return axios.delete(`api/management_plans/${payload.id}`)
                .then((response) => response);
        },
        listSearch({}, payload) {
            return axios.get(`api/management_plans/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
