import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";
import vueForm from "./Parts/Form/index";

class ConstituentPermit extends Base {

    static getComponents() {
        return {
            "items-grid" : vueGrid,
            "constituent-permit-form" : vueForm
        }
    }

    static buildForm(data) {
        let obj = {
            Concession: data.Concession.Id,
            permit_number: data.PermitNumber,
            geometry: data.Geometry,
            permit_type: data.PermitType.Id
        }

        return obj;
    }

    static index(data) {
        return store.dispatch('constituent_permit/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('constituent_permit/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('constituent_permit/get', {id});
    }

    static update(id, data) {
        return store.dispatch('constituent_permit/update', {id, data}).then((response) => response.data);
    }

    static approve(id, data) {
        return store.dispatch('constituent_permit/approve', {id, data}).then();
    }


    static delete(id) {
        return store.dispatch('constituent_permit/delete', {id});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('constituent_permit/listSearch', {name, limit}).then(response => response.data);
    }

}

export default ConstituentPermit;
