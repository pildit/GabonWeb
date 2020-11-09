import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class Company extends Base {

    static getComponents() {
        return {
            "companies-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('company/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('company/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('company/get', {id});
    }

    static update(id, data) {
        return store.dispatch('company/update', {id, data});
    }

}

export default Company;