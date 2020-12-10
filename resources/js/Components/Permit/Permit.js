import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class Permit extends Base {

    static getComponents() {
        return {
            "permit-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('permit/index', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('permit/get', {id});
    }

    static getPermitItems (id) {
        return store.dispatch('permit/getPermitItems', {id});
    }

    static delete(id) {
        return store.dispatch('permit/delete', {id});
    }

    static approve(id, data) {
        return store.dispatch('permit/approve', {id, data});
    }

}

export default Permit;
