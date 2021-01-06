import Base from "../../Base";
import store from 'store/store';
import vuePlans from "../DevelopmentPlan/Parts/Grid";

class DevelopmentPlan extends Base {

    static getComponents() {
        return {
            "development-unit-plans" : vuePlans,
        }
    }
    static buildForm(data) {
        let obj = {
            Species: data.Species.Id,
            MinimumExploitableDiameter: data.MinimumExploitableDiameter,
            VolumeTariff: data.VolumeTariff,
            Increment: data.Increment,
            CreatedAt: data.CreatedAt,
            Approved: data.Approved
        }
        if(data.VolumeTariff) {
            obj['VolumeTariff'] = data.VolumeTariff
        }
        if(data.Increment) {
            obj['Increment'] = data.Increment
        }

        return obj;
    }

    static index(data) {
        return store.dispatch('development_plan/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('development_plan/add', data);
    }

    static update(id, data) {
        return store.dispatch('development_plan/update', {id,data});
    }

    static approve(id, data) {
        return store.dispatch('development_plan/approve', {id, data});
    }

    static listSearch(name, limit = 100) {
        return store.dispatch('development_plan/listSearch', {name, limit}).then(response => response.data);
    }

}

export default DevelopmentPlan
