import Base from "../../Base";
import vueGrid from './Parts/Grid/index';
import vueInventoryGrid from './Parts/InventoryGrid/index';
import vueForm from './Parts/Form/index';
import store from "store/store";

class AAC extends Base {

    static getComponents() {
        return {
            "aac-grid" : vueGrid,
            "aac-form" : vueForm,
            "aac-inventory-grid" : vueInventoryGrid
        }
    }

    static buildForm(data) {
        let obj = {
            AacId : data.AacId,
            Name : data.Name,
            ProductType : data.ProductType.Id,
            ManagementUnit : data.ManagementUnit.Id
        }

        if(data.ManagementPlan) {
            obj['ManagementPlan'] = data.ManagementPlan.Id;
        }

        if(data.Geometry) {
            obj['Geometry'] = data.Geometry;
        }

        return obj;
    }

    static index(data) {
        return store.dispatch('aac/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('aac/add', data);
    }

    static update(id, data) {
        return store.dispatch('aac/update', {id, data});
    }

    static approve(id, data) {
        return store.dispatch('aac/approve', {id, data});
    }

    static approveInventory(id, data) {
        return store.dispatch('aac_inventory/approve', {id, data});
    }


}

export default AAC
