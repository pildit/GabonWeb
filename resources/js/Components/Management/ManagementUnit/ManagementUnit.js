import Base from "../../Base";
import vueGrid from './Parts/Grid/index';
import vueForm from './Parts/Form/index';
import store from "store/store";

class ManagementUnit extends Base {

    static getComponents() {
        return {
            "management-unit-grid" : vueGrid,
            "management-unit-form" : vueForm
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

    static delete(id) {
        return store.dispatch('management_unit/delete', {id});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('management_unit/listSearch', {name, limit}).then(response => response.data);
    }

}

export default ManagementUnit
