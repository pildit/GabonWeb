import ManagementUnit from "../../ManagementUnit";
import grid from "./grid";
import store from "store/store";

export default (selector, options) => {
    return ManagementUnit.renderTable(selector, grid(options), {
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
            },
            createRoute() {
                return ManagementUnit.buildRoute('management_units.create');
            }
        }
    })
}
