import Map from 'ol'
import axios from 'axios'; // Will be used for requests once we have the endpoints

export default {
    state: {
        map: new Map()
    },
    getters: {
        map(state) {
            return state.map;
        }
    },
    mutations: {
        map(state, map) {
            state.map = map;
        }
    },
    actions: {
        // $fetchMenu({commit, state}) {
        //     return axios.get('/api/menu')
        //         .then((response) => {
        //             commit('menu', response.data['data'])
        //         });
        // }
    }
}
