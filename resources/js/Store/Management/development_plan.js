import axios from 'axios';

export default {
    namespaced: true,
    actions: {
        add({}, payload) {
            return axios.post('api/development_plans', payload)
                .then((response) => response.data)
        },
        update({}, payload) {
            let id = payload.id;
            let data = payload.data;
            return axios.patch(`api/development_plans/${id}`, data)
                .then((response) => response.data);
        }
    }
}
