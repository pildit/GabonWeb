import Base from "../Base";
import store from "store/store"
import vueGrid from "./Parts/Grid/index";

class ProductType extends Base {

    static getComponents() {
        return {
            "product-types-grid" : vueGrid
        }
    }

    static index(data) {
        return store.dispatch('productType/index', data).then((response) => response.data);
    }

    static add(data) {
        return store.dispatch('productType/add', data).then((response) => response.data);
    }

    static get(id) {
        return store.dispatch('productType/get', {id});
    }

    static update(id, data) {
        return store.dispatch('productType/update', {id, data});
    }

    static delete(id) {
        return store.dispatch('productType/delete', {id});
    }

}

export default ProductType;
