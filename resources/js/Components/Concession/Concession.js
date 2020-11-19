import Base from "../Base";
import store from "store/store"

class Concession extends Base {

    static listSearch(name, limit = 100) {
        return store.dispatch('concession/listSearch', {name, limit}).then(response => response.data);
    }
}

export default Concession
