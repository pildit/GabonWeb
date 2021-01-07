import axios from 'axios';

export default {
    namespaced: true,
    state: {
        development_plans: []
    },
    getters: {
        development_plans(state) {
            return state.development_plans;
        }
    },
    mutations: {
        development_plans(state, development_plans) {
            state.development_plans = development_plans;
        }
    },
    actions: {
        index({commit}, payload) {
            return axios.get(`api/development_plans/${payload.id}`,{params: payload})
                .then((response) => {
                    commit('development_plans', response.data.data);
                    return response;
                })
        },
        add({}, payload) {
            return axios.post('api/development_plans', payload)
                .then((response) => response.data)
        },
        update({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/development_plans/${id}`, data)
                .then((response) => response.data);
        },
        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/development_plans/approve/${id}`, data)
                .then((response) => response);
        },
        delete({}, payload) {
            return axios.delete(`api/development_plans/${payload.id}`)
                .then((response) => response);
        },
        listSearch({}, payload) {
            return axios.get(`api/development_plans/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
