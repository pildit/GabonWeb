import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class Quality extends Base {

    static getComponents() {
        return {
            "quality-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('quality/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('quality/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('quality/get', {id});
    }

    static update(id, data) {
        return store.dispatch('quality/update', {id, data});
    }

}

export default Quality;