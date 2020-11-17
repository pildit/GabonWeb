import Base from "components/Base";
import vueNavMenu from "./Parts/Navigation/index";
import vueLandingPage from "./Parts/Landingpage/index";
import vueNomenclatures from "./Parts/Nomenclatures/index";
import vueConcessions from "./Parts/Concessions/index";
import vueManagement from "./Parts/Management/index";

class Pages extends Base {

    static getComponents() {
        return {
            "navigation-menu" : vueNavMenu,
            "landingpage" : vueLandingPage,
            "nomenclatures": vueNomenclatures,
            "concessions": vueConcessions,
            "nomenclatures": vueNomenclatures,
            "management": vueManagement,
        };
    }

}

export default Pages;
