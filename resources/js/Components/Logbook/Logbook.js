import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class Logbook extends Base {

    static getComponents() {
        return {
            "logbook-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('logbooks/index', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('logbooks/get', {id});
    }

    static approve(id, data) {
        return store.dispatch('logbooks/approve', {id, data});
    }

    static approve_item (id, data) {
        return store.dispatch('logbooks/approve_item', {id, data});
    }

    static update(id, data) {
        return store.dispatch('logbooks/update', {id});
    }

}

export default Logbook;
