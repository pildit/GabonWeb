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
        },

        mutateAnnualAllowableCutInventory(state, data) {
            // TODO
        },

        mutateAnnualAllowableCuts(state, data) {
            // TODO
        },

        mutateConcessions(state, data) {
            // TODO
        },

        mutableDevelopmentUnits(state, data) {
            // TODO
        },

        mutableManagmentUnits(state, data) {
            // TODO
        },

        mutableParcels(state, data) {
            // TODO
        },

        mutablePermits(state, data) {
            // TODO
        }
    },
    actions: {

        /* Set actions */
        setMap({ commit }, map) {
            commit('mutateMap', map)
        },

        /* Requests */
        getAnnualAllowableCutInventory({ commit }, payload) {
            return axios.get(`/api/annual_allowable_cut_inventory/vectors`)
                .then((response) => response.data)
                .then((responseData) => commit('mutateAnnualAllowableCutInventory', responseData.data)
                );
        },

        getAnnualAllowableCuts({ commit }, payload) {
            return axios.get(`/api/annual_allowable_cuts/vectors`)
                .then((response) => response.data)
                .then((responseData) => commit('mutateAnnualAllowableCuts', responseData.data)
                );
        },

        getConcessions({ commit }, payload) {
            return axios.get(`/api/concessions/vectors`)
                .then((response) => response.data)
                .then((responseData) => commit('mutateConcessions', responseData.data)
                );
        },

        getDevelopmentUnits({ commit }, payload) {
            return axios.get(`/api/development_units/vectors`)
                .then((response) => response.data)
                .then((responseData) => commit('mutableDevelopmentUnits', responseData.data)
                );
        },

        getManagmentUnits({ commit }, payload) {
            return axios.get(`/api/management_units/vectors`)
                .then((response) => response.data)
                .then((responseData) => commit('mutableManagmentUnits', responseData.data)
                );
        },

        getParcelsVectors({ commit }, payload) {
            return axios.get(`/api/parcels/vectors`)
                .then((response) => response.data)
                .then((responseData) => commit('mutableParcels', responseData.data)
                );
        },

        getPermits({ commit }, payload) {
            return axios.get(`/api/permits/vectors`)
            .then((response) => response.data)
            .then((responseData) => commit('mutablePermits', responseData.data)
            );
        }
    }
}
