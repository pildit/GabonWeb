import ManagementPlan from "../../ManagementPlan";
import grid from "./grid";
import store from "store/store";
import ManagementUnit from "../../../ManagementUnit/ManagementUnit";


export default (selector, options) => {
    return ManagementPlan.renderTable(selector, grid(options), {
        store,
        data: {
            sort: {
                direction: "asc",
                field: "id"
            },
            search: null
        },
        methods: {
            fetchData() {
                Vent.$emit('grid-refresh', {search: this.search});
            }
        }
    })
}
