import Base from "../Base";
import vueDetails from "./Parts/Details"
import vueLoginForm from "./Parts/Login";

class User extends Base {

    static getComponents() {
        return {
            "user-details" : vueDetails,
            "login-form" : vueLoginForm
        }
    }

}

export default User;
