import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class Concession extends Base {


    static getComponents() {
        return {
            "concessions-grid": vueGrid,
        }
    }

    static approve(id, data) {
        return store.dispatch('concession/approve', {id, data});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('concession/listSearch', {name, limit}).then(response => response.data);
    }
}

export default Concession
