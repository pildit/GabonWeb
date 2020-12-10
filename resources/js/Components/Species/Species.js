import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class Species extends Base {

    static getComponents() {
        return {
            "species-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('species/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('species/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('species/get', {id});
    }

    static update(id, data) {
        return store.dispatch('species/update', {id, data});
    }

    static delete(id) {
        return store.dispatch('species/delete', {id});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('species/listSearch', {name, limit}).then(response => response.data);
    }

}

export default Species;
