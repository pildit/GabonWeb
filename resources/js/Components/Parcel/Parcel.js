import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";
import vueForm from "./Parts/Form/index";

class Parcel extends Base {

    static getComponents() {
        return {
            "items-grid" : vueGrid,
            "parcel-form" : vueForm,
        }
    }

    static index(data) {
        return store.dispatch('parcels/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('parcels/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('parcels/get', {id});
    }

    static update(id, data) {
        return store.dispatch('parcels/update', {id, data}).then((response) => response.data);
    }

    static approve(id, data) {
        return store.dispatch('parcels/approve', {id, data});
    }

}

export default Parcel;
