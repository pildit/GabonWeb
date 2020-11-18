import axios from "axios";

export default {
    namespaced: true,
    state: {
    },
    actions: {
        listSearch({}, payload) {
            return axios.get(`api/concessions/list?name=${payload.name}&limit=${payload.limit}`)
                .then((response) => response);
        }
    }
}
