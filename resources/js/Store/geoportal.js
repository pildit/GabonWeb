import { Map, View } from 'ol'
import OSM from "ol/source/OSM";
import TileLayer from "ol/layer/Tile";
import { fromLonLat } from "ol/proj";

import axios from 'axios'; // Will be used for requests once we have the endpoints

export default {
    namespaced: true,
    state: {
        map: new Map({
            // the map will be created using the 'map-root' ref
            // target: this.$refs["map-root"],
            layers: [
                // adding a background tiled layer
                new TileLayer({
                    source: new OSM(), // tiles are served by OpenStreetMap
                }),
            ],
            //the map view will initially show the whole world
            view: new View({
                zoom: 7,
                center: fromLonLat([11.609454, -0.803698]), //Gabon coord
                constrainResolution: true,
            }),
        })
    },
    getters: {
        map(state) {
            return state.map;
        }
    },
    mutations: {
        mutateMap(state, map) {
            state.map = map;
        }
    },
    actions: {
        
        /* Set actions */
        setMap({commit}, map) {
            commit('mutateMap', map)
        }

        // $fetchMenu({commit, state}) {
        //     return axios.get('/api/menu')
        //         .then((response) => {
        //             commit('menu', response.data['data'])
        //         });
        // }
    }
}
