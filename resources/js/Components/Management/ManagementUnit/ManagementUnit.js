import Base from "../../Base";
import vueGrid from './Parts/Grid/index';
import vueForm from './Parts/Form/index';

class ManagementUnit extends Base {

    static getComponents() {
        return {
            "management-unit-grid" : vueGrid,
            "management-unit-form" : vueForm
        }
    }

    static approve(id, value) {

    }

}

export default ManagementUnit
