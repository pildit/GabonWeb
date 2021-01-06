import Base from "../../Base";
import store from 'store/store';
import vuePlans from './Parts/Grid/index';

class ManagementPlan extends Base {

    static getComponents() {
        return {
            "management-unit-plans" : vuePlans,
        }
    }
    static buildForm(data, unit_id) {
        let obj = {
            Species: data.Species.Name,
            GrossVolumeUFG: data.GrossVolumeUFG,
            GrossVolumeYear: data.GrossVolumeYear,
            YieldVolumeYear: data.YieldVolumeYear,
            CommercialVolumeYear: data.CommercialVolumeYear,
            Number: data.Number,
            Approved: data.Approved,
            CreatedAt: data.CreatedAt,
        }

        return obj;
    }
    static index(data) {
        return store.dispatch('management_plan/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('management_plan/add', data);
    }

    static update(id, data) {
        return store.dispatch('management_plan/update', {id,data});
    }

    static approve(id, data) {
        return store.dispatch('management_plan/approve', {id, data});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('management_plan/listSearch', {name, limit}).then(response => response.data);
    }

}

export default ManagementPlan
