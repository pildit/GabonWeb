import Base from "../../Base";
import vueGrid from './Parts/Grid/index';
import vueForm from './Parts/Form/index';
import store from "store/store";

class DevelopmentUnit extends Base {

    static getComponents() {
        return {
            "development-unit-grid" : vueGrid,
            "development-unit-form" : vueForm,
        }
    }

    static buildForm(data) {
        let obj = {
            Number : data.Number,
            Name : data.Name,
            Concession : data.Concession.Id,
            ProductType : data.ProductType.Id,
            Start: data.Start,
            End: data.End
        }

        if(data.Geometry) {
            obj['Geometry'] = data.Geometry;
        }

        return obj;
    }

    static index(data) {
        return store.dispatch('development_unit/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('development_unit/add', data);
    }

    static update(id, data) {
        return store.dispatch('development_unit/update', {id, data});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('development_unit/listSearch', {name, limit}).then(response => response.data);
    }

    static approve(id, data) {
        return store.dispatch('development_unit/approve', {id, data})
    }

    static delete(id) {
        return store.dispatch('development_unit/delete', {id})
    }

}
export default DevelopmentUnit;
