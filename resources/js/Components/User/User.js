import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid";
import vueDetails from "./Parts/Details"
import vueForm from "./Parts/Form";
import vueLogin from "./Parts/Login";
import vueRegister from "./Parts/Register";
import vueAccountConfirmation from "./Parts/Confirmation";
import ForgotPassword from "./Parts/ForgotPassword";
import ResetPassword from "./Parts/ResetPassword";
import Notification from "components/Common/Notifications/Notification";
import company from "../../Store/company";

class User extends Base {

    static getComponents() {
        return {
            "users-grid" : vueGrid,
            "user-form" : vueForm,
            "user-details" : vueDetails,
            "login-form" : vueLogin,
            "register-form" : vueRegister,
            "account-confirmation" : vueAccountConfirmation,
            'forgot-password-form' : ForgotPassword,
            'reset-password' : ResetPassword
        }
    }

    static getStatusLabel(status) {
        let statuses = {
            0: "Not Confirmed",
            1: "Pending",
            2: "Active",
            3: "Disabled"
        }

        return statuses[status] || '';
    }

    static getStatusClass(status) {
        let statuses = {
            0: "badge-light",
            1: "badge-warning",
            2: "badge-success",
            3: "badge-danger"
        }

        return statuses[status] || 'badge-dark'
    }

    static buildForm(user) {

        let obj = {
            firstname : user.firstname,
            lastname : user.lastname,
            email: user.email,
            roles: _.map(user.roles, 'id')
        }
        if(user.company) {
            obj.company_id = user.company['Id'];
        }
        if(user.employee_type) {
            obj.employee_type = user.employee_type['id'];
        }
        if(user.permissions) {
            obj.permissions = _.map(user.permissions, 'id');
        }
        if(user.role) {
            obj.role_name = user.role;
        }
        if(user.password) {
            obj.password = user.password;
            obj.password_confirmation = user.password_confirmation;
        }

        return obj;
    }

    static login(email, password) {
        let data = {email, password};
        return store.dispatch('user/login', data).then((response) => response.data);
    }

    static register(data) {
        return store.dispatch('user/register', data).then((response) => {
            Notification.success('User', response.data.message);
            return response.data;
        });
    }

    static forgot(email) {
        let data = {email};
        return store.dispatch('user/forgot', data).then((response) => response.data);
    }

    static verify(data) {
        return store.dispatch('user/verify', data).then((response) => {
            Notification.success('User', response.data.message);
            return response.data;
        })
    }

    static add(data) {
        return store.dispatch('user/add', data).then((response) => {
            Notification.success('User', response.data.message);
            return response.data;
        });
    }

    static update(id,data) {
        return store.dispatch('user/update', {id, data}).then((response) => {
            Notification.success('User', response.data.message)
            return response.data;
        });
    }

    static approve(id) {
        return store.dispatch('user/approve', {id}).then((response) => {
            Notification.success('User', response.data.message)
            return response.data;
        });
    }

    static delete(id) {
        return store.dispatch('user/delete', {id});
    }

    static reset(data) {
        return store.dispatch('user/reset', {data}).then((response) => response.data);
    }

    static resendConfirmation(id) {
        return store.dispatch('user/resendConfirmation', {id}).then((response) => {
            Notification.success('User', response.data.message)
            return response.data;
        });
    }

}

export default User;
