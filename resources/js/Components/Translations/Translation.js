import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class Translation extends Base {

    static getComponents() {
        return {
            "translation-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('translation/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('translation/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('translation/get', {id});
    }

    static update(id, data) {
        return store.dispatch('translation/update', {id, data});
    }

    static delete(id, data) {
        return store.dispatch('translation/delete', {id});
    }

}

export default Translation;
