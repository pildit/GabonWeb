import DevelopmentPlan from "../../DevelopmentPlan";
import grid from "./grid";
import store from "store/store";


export default (selector, options) => {
    return DevelopmentPlan.renderTable(selector, grid(options), {
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
