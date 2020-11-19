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
            Name : data.Name,
            Concession : data.Concession.Id,
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

}
export default DevelopmentUnit;
