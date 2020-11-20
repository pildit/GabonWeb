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

    static approve(id) {
        return store.dispatch('logbooks/approve', {id});
    }

    static update(id, data) {
        return store.dispatch('logbooks/update', {id});
    }

}

export default Logbook;
