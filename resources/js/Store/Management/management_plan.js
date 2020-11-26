import axios from 'axios';

export default {
    namespaced: true,
    actions: {
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
        listSearch({}, payload) {
            return axios.get(`api/management_units/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
