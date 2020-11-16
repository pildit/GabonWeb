import Base from "../../Base";
import vueGrid from './Parts/Grid/index';

class DevelopmentUnit extends Base {

    static getComponents() {
        return {
            "development-unit-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('development_unit/index', data).then((response) => response.data);
    }

}
export default DevelopmentUnit;
