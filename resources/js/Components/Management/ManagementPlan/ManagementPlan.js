import Base from "../../Base";
import store from 'store/store';

class ManagementPlan extends Base {

    static buildForm(data, unit_id) {
        let obj = {
            ManagementUnit: unit_id,
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

}

export default ManagementPlan
