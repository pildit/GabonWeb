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
        return store.dispatch('role/get', data).then((response) => response.data);
    }

}

export default Role;
