import axios from 'axios';

export default {
    namespaced: true,
    actions: {
        add({}, payload) {
            return axios.post('api/annual_operation_plans', payload)
                .then((response) => response.data)
        },
        update({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/annual_operation_plans/${id}`, data)
                .then((response) => response.data);
        },
        approve({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/annual_operation_plans/approve/${id}`, data)
                .then((response) => response);
        }
    }
}
