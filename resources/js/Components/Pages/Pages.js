import Base from "components/Base";
import vueNavMenu from "./Parts/Navigation/index";
import vueLandingPage from "./Parts/Landingpage/index";

class Pages extends Base {

    static getComponents() {
        return {
            "navigation-menu" : vueNavMenu,
            "landingpage" : vueLandingPage
        };
    }

}

export default Pages;
