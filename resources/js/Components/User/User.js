import Base from "../Base";
import store from "store/store"
import vueDetails from "./Parts/Details"
import vueLoginForm from "./Parts/Login";

class User extends Base {

    static getComponents() {
        return {
            "user-details" : vueDetails,
            "login-form" : vueLoginForm
        }
    }

    static login(email, password) {
        let data = {email, password};
        return store.dispatch('user/login', data).then((response) => response.data)
    }

}

export default User;
