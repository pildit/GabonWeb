import Base from "../Base";
import store from "store/store"
import vueDetails from "./Parts/Details"
import vueLogin from "./Parts/Login";
import vueRegister from "./Parts/Register";
import vueAccountConfirmation from "./Parts/Confirmation";

class User extends Base {

    static getComponents() {
        return {
            "user-details" : vueDetails,
            "login-form" : vueLogin,
            "register-form" : vueRegister,
            "account-confirmation" : vueAccountConfirmation
        }
    }

    static login(email, password) {
        let data = {email, password};
        return store.dispatch('user/login', data).then((response) => response.data)
    }

    static register(data) {
        return store.dispatch('user/register', data).then((response) => response.data);
    }

    static verify(data) {
        return store.dispatch('user/verify', data).then((response) => response.data);
    }

}

export default User;
