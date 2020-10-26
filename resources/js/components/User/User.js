import Base from "../Base";
import vueDetails from "./Parts/Details/index"

class User extends Base {

    static getComponents() {
        return {
            "user-details" : vueDetails,
        }
    }

}

export default User;
