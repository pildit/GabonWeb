import Base from "../Base";
import vueGrid from "./Parts/Grid/index";

class Role extends Base {

    static getComponents() {
        return {
            "roles-grid" : vueGrid
        }
    }

}

export default Role;
