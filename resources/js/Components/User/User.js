import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid";
import vueDetails from "./Parts/Details"
import vueForm from "./Parts/Form";
import vueLogin from "./Parts/Login";
import vueRegister from "./Parts/Register";
import vueAccountConfirmation from "./Parts/Confirmation";
import Notification from "components/Common/Notifications/Notification";

class User extends Base {

    static getComponents() {
        return {
            "users-grid" : vueGrid,
            "user-form" : vueForm,
            "user-details" : vueDetails,
            "login-form" : vueLogin,
            "register-form" : vueRegister,
            "account-confirmation" : vueAccountConfirmation
        }
    }

    static getStatusLabel(status) {
        let statuses = {
            0: "Disabled",
            1: "Not Confirmed",
            2: "Active"
        }

        return statuses[status] || '';
    }

    static getStatusClass(status) {
        let statuses = {
            0: "badge-light",
            1: "badge-warning",
            2: "badge-success"
        }

        return statuses[status] || 'badge-dark'
    }

    static login(email, password) {
        let data = {email, password};
        return store.dispatch('user/login', data).then((response) => response.data);
    }

    static register(data) {
        return store.dispatch('user/register', data).then((response) => {
            Notification.success('User', data.message);
            return response.data;
        });
    }

    static verify(data) {
        return store.dispatch('user/verify', data).then((response) => {
            Notification.success('User', data.message);
            return response.data;
        })
    }

    static add(data) {
        return store.dispatch('user/add', data).then((response) => {
            Notification.success('User', data.message);
            return response.data;
        });
    }

    static update(data) {
        return store.dispatch('user/update', data).then((response) => {
            Notification.success('User', data.message)
            return response.data;
        });
    }

    static approve(id) {
        return store.dispatch('user/approve', {id}).then((response) => {
            Notification.success('User', data.message)
            return response.data;
        });
    }

    static resendConfirmation(id) {
        return store.dispatch('user/resendConfirmation', {id}).then((response) => {
            Notification.success('User', data.message)
            return response.data;
        });
    }

}

export default User;
