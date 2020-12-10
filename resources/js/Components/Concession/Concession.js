import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";
import vueFrom from "./Parts/Form/index";

class Concession extends Base {


    static getComponents() {
        return {
            "concessions-grid": vueGrid,
            "concessions-form": vueFrom
        }
    }

    static buildForm(data) {
        let obj = {
            ConstituentPermit: data.ConstituentPermit.Id,
            Company: data.Company.Id,
            Continent: data.Continent.Name,
            ProductType: data.ProductType.Id,
            Number: data.Number,
            Name: data.Name,
            Geometry: data.Geometry,
        }

        return obj;
    }

    static add(data) {
        return store.dispatch('concession/add', data).then((response) => response.data);
    }

    static update(id, data) {
        return store.dispatch('concession/update', {id, data}).then((response) => response.data);
    }

    static approve(id, data) {
        return store.dispatch('concession/approve', {id, data});
    }

    static delete(id) {
        return store.dispatch('concession/delete', {id});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('concession/listSearch', {name, limit}).then(response => response.data);
    }
}

export default Concession
