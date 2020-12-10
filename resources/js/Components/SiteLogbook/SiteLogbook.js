import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class SiteLogbook extends Base {

    static getComponents() {
        return {
            "site-logbook-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('sitelogbooks/index', data).then((response) => response.data);
    }

    static approve(id, data) {
        return store.dispatch('sitelogbooks/approve', {id, data});
    }

    static update(id, data) {
        return store.dispatch('sitelogbooks/update', {id});
    }

    static delete(id) {
        return store.dispatch('sitelogbooks/delete', {id});
    }

}

export default SiteLogbook;
