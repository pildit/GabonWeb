import Base from "../../Base";
import store from 'store/store';

class DevelopmentPlan extends Base {

    static buildForm(data, unit_id) {
        let obj = {
            DevelopmentUnit: unit_id,
            Number: data.Number,
            Species: data.Species.Id,
            MinimumExploitableDiameter: data.MinimumExploitableDiameter
        }
        if(data.VolumeTariff) {
            obj['VolumeTariff'] = data.VolumeTariff
        }
        if(data.Increment) {
            obj['Increment'] = data.Increment
        }

        return obj;
    }

    static add(data) {
        return store.dispatch('development_plan/add', data);
    }

    static update(id, data) {
        return store.dispatch('development_plan/update', {id,data});
    }

}

export default DevelopmentPlan
