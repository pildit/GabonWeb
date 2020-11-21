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

    static get(id) {
        return store.dispatch('sitelogbooks/get', {id});
    }

    static getItemLogs (id) {
        return store.dispatch('sitelogbooks/getItemLogs', {id});
    }

    static approve(id) {
        return store.dispatch('sitelogbooks/approve', {id});
    }

    static approve_item (id) {
        return store.dispatch('sitelogbooks/approve_item', {id});
    }

    static update(id, data) {
        return store.dispatch('sitelogbooks/update', {id});
    }

}

export default SiteLogbook;
