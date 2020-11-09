import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class PermitType extends Base {

    static getComponents() {
        return {
            "permit-types-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('permittype/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('permittype/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('permittype/get', {id});
    }

    static update(id, data) {
        return store.dispatch('permittype/update', {id, data});
    }

}

export default PermitType;