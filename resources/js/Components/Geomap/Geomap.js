import Base from "components/Base";
import vueSideMap from "./Parts/SideMap/index";

class Geomap extends Base {

    static getComponents() {
        return {
            "sidemap": vueSideMap,
        };
    }

}

export default Geomap;
