import { Map, View } from 'ol'
import OSM from "ol/source/OSM";
import TileLayer from "ol/layer/Tile";
import { fromLonLat } from "ol/proj";

import axios from 'axios'; // Will be used for requests once we have the endpoints

/* Helper function to parametrize strings */
function getParametrizedString(apiString, payload) {

    const originalApiString = apiString

    const filters = payload
    const filterLenght = Object.keys(filters).length

    if (filterLenght <= 0)
        return apiString

    apiString += '?'
    let iterator = 0
    Object.keys(filters).forEach(function (key) {

        const value = filters[key]
        let paramValue = value

        if (value === undefined) {
            return originalApiString
        }

        if (Array.isArray(value)) {
            paramValue = value.join(',')
        }
        
        apiString += `${key}=${paramValue}`
        
        /* Prepare for the next parameter */
        ++iterator < filterLenght ? apiString += '&' : null
    });
    
    console.log(apiString)
    return apiString
}

export default {
    namespaced: true,
    state: {

        // map: new Map({
        //     // the map will be created using the 'map-root' ref
        //     // target: this.$refs["map-root"],
        //     layers: [
        //         // adding a background tiled layer
        //         new TileLayer({
        //             source: new OSM(), // tiles are served by OpenStreetMap
        //         }),
        //     ],
        //     // the map view will initially show the whole world
        //     view: new View({
        //         zoom: 7,
        //         center: fromLonLat([11.609454, -0.803698]), // Gabon coord
        //         constrainResolution: true,
        //     }),
        // }),
        
        annualAllowableCutInventory: [],
        annualAllowableCuts: [],
        concessions: [],
        developmentUnits: [],
        managmentUnits: [],
        parcels: [],
        permits: []
    },
    getters: {

        map(state) {
            return state.map;
        },

        annualAllowableCutInventory(state) {
            return state.annualAllowableCutInventory
        },

        annualAllowableCuts(state) {
            return state.annualAllowableCuts
        },

        concessions(state) {
            return state.concessions
        },

        developmentUnits(state) {
            return state.developmentUnits
        },

        managmentUnits(state) {
            return state.managmentUnits
        },

        parcels(state) {
            return state.parcels
        },

        permits(state) {
            return state.permits
        }
    },
    mutations: {
        mutateMap(state, map) {
            state.map = map;
        },

        mutateAnnualAllowableCutInventory(state, data) {
            state.annualAllowableCutInventory = data;
        },

        mutateAnnualAllowableCuts(state, data) {
            state.annualAllowableCuts = data
        },

        mutateConcessions(state, data) {
            state.concessions = data
        },

        mutableDevelopmentUnits(state, data) {
            state.developmentUnits = data
        },

        mutableManagmentUnits(state, data) {
            state.managmentUnits = data
        },

        mutableParcels(state, data) {
            state.parcels = data
        },

        mutablePermits(state, data) {
            state.permits = data
        }
    },
    actions: {

        /* Set actions */
        setMap({ commit }, map) {
            commit('mutateMap', map)
        },

        /* Requests */
        getAnnualAllowableCutInventory({ commit }, payload) {

            let apiString = `/api/annual_allowable_cut_inventory/vectors`

            if (payload) {
                apiString = getParametrizedString(apiString, payload)
            }

            return axios.get(apiString)
                .then((responseData) => commit('mutateAnnualAllowableCutInventory', responseData.data)
                );
        },

        getAnnualAllowableCuts({ commit }, payload) {

            let apiString = `/api/annual_allowable_cuts/vectors`

            if (payload) {
                apiString = getParametrizedString(apiString, payload)
            }

            return axios.get(apiString)
                .then((responseData) => commit('mutateAnnualAllowableCuts', responseData.data)
                );
        },

        getConcessions({ commit }, payload) {

            let apiString = `/api/concessions/vectors`

            if (payload) {
                apiString = getParametrizedString(apiString, payload)
            }

            return axios.get(apiString)
                .then((responseData) => commit('mutateConcessions', responseData.data)
                );
        },

        getDevelopmentUnits({ commit }, payload) {

            let apiString = `/api/development_units/vectors`

            if (payload) {
                apiString = getParametrizedString(apiString, payload)
            }

            return axios.get(apiString)
                .then((responseData) => commit('mutableDevelopmentUnits', responseData.data)
                );
        },

        getManagmentUnits({ commit }, payload) {

            let apiString = `/api/management_units/vectors`

            if (payload) {
                apiString = getParametrizedString(apiString, payload)
            }

            return axios.get(apiString)
                .then((responseData) => commit('mutableManagmentUnits', responseData.data)
                );
        },

        getParcelsVectors({ commit }, payload) {

            let apiString = `/api/parcels/vectors`

            if (payload) {
                apiString = getParametrizedString(apiString, payload)
            }

            return axios.get(apiString)
                .then((responseData) => commit('mutableParcels', responseData.data)
                );
        },

        getPermits({ commit }, payload) {

            let apiString = `/api/permits/vectors`

            if (payload) {
                apiString = getParametrizedString(apiString, payload)
            }

            return axios.get(apiString)
                .then((responseData) => commit('mutablePermits', responseData.data)
                );
        }
    }
}
