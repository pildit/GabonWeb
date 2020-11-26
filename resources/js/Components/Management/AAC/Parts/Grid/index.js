import AAC from "../../AAC";
import grid from "./grid";
import store from "store/store";

export default (selector, options) => {
    return AAC.renderTable(selector, grid(options), {
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
                return AAC.buildRoute('aac.create');
            }
        }
    })
}
