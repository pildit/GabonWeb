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

    static index(data) {
        return store.dispatch('development_unit/index', data).then((response) => response.data);
    }

    static update(id, data) {
        return store.dispatch('development_unit/update', {id, data}).then((response) =>  response.data);
    }

}
export default DevelopmentUnit;
