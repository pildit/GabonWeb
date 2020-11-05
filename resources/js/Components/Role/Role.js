import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class Role extends Base {

    static getComponents() {
        return {
            "roles-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('role/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('role/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('role/get', {id});
    }

    static update(id, data) {
        return store.dispatch('role/update', {id, data});
    }

}

export default Role;
