import axios from 'axios';

export default {
    namespaced: true,
    actions: {
        add({}, payload) {
            return axios.post('api/development_plans', payload)
                .then((response) => response.data)
        }
    }
}
