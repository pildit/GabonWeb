import Base from "../../Base";
import vueGrid from './Parts/Grid/index';
import vueForm from './Parts/Form/index';
import store from "store/store";

class AAC extends Base {

    static getComponents() {
        return {
            "aac-grid" : vueGrid,
            "aac-form" : vueForm
        }
    }

    static buildForm(data) {
        let obj = {
            Number : data.Number,
            Name : data.Name,
            ProductType : data.ProductType.Id,
            DevelopmentUnit : data.DevelopmentUnit.Id
        }

        if(data.Geometry) {
            obj['Geometry'] = data.Geometry;
        }

        return obj;
    }

    static index(data) {
        return store.dispatch('management_unit/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('management_unit/add', data);
    }

    static update(id, data) {
        return store.dispatch('management_unit/update', {id, data});
    }

    static approve(id, data) {
        return store.dispatch('management_unit/approve', {id, data});
    }

}

export default AAC
