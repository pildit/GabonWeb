import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";
import vueForm from "./Parts/Form/index";

class ConstituentPermit extends Base {

    static getComponents() {
        return {
            "items-grid" : vueGrid,
            "constituent-permit-form" : vueForm
        }
    }

    static index(data) {
        return store.dispatch('constituentPermit/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('constituentPermit/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('constituentPermit/get', {id});
    }

    static update(id, data) {
        return store.dispatch('constituentPermit/update', {id, data});
    }

}

export default ConstituentPermit;
