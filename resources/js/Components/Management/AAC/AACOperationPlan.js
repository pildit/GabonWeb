import Base from "../../Base";
import store from "store/store";

class AACOperationPlan extends Base {

    static buildForm(data, id) {
        let obj = {
            AnnualAllowableCut: id,
            Number: data.Number,
            Species: data.Species.Id,
            ExploitableVolume: data.ExploitableVolume,
            NonExploitableVolume: data.NonExploitableVolume,
            VolumePerHectare: data.VolumePerHectare,
            AverageVolume: data.AverageVolume,
            TotalVolume: data.TotalVolume,
        }
        return obj;
    }

    static add(data) {
        return store.dispatch('aac_plan/add', data);
    }

    static update(id, data) {
        return store.dispatch('aac_plan/update', {id,data});
    }


}

export default AACOperationPlan;
