import Base from "components/Base";
import vueNavMenu from "./Parts/Navigation/index";
import vueLandingPage from "./Parts/Landingpage/index";
import vueNomenclatures from "./Parts/Nomenclatures/index";
import vueGeoportalPage from "./Parts/Geoportal/index";

class Pages extends Base {

    static getComponents() {
        return {
            "navigation-menu": vueNavMenu,
            "geoportalpage": vueGeoportalPage,
            "landingpage" : vueLandingPage,
            "nomenclatures": vueNomenclatures
        };
    }

}

export default Pages;
