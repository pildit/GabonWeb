import Base from "../../Base";
import store from 'store/store';

class ManagementPlan extends Base {

    static buildForm(data, unit_id) {
        let obj = {
            ManagementUnit: unit_id,
            Number: data.Number,
            Species: data.Species.Id,
            GrossVolumeUFG: data.GrossVolumeUFG,
            GrossVolumeYear: data.GrossVolumeYear,
            YieldVolumeYear: data.YieldVolumeYear,
            CommercialVolumeYear: data.YieldVolumeYear,
        }

        return obj;
    }

    static add(data) {
        return store.dispatch('management_plan/add', data);
    }

    static update(id, data) {
        return store.dispatch('management_plan/update', {id,data});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('management_plan/listSearch', {name, limit}).then(response => response.data);
    }

}

export default ManagementPlan
