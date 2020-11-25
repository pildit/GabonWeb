import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class SiteLogbookItem extends Base {

    static getComponents() {
        return {
            "site-logbook-item-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('sitelogbookitems/index', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('sitelogbookitems/get', {id});
    }

    static approve(id) {
        return store.dispatch('sitelogbookitems/approve', {id});
    }

}

export default SiteLogbookItem;
