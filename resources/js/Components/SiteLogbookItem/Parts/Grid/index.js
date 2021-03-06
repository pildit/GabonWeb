import SiteLogbookItem from "../../SiteLogbookItem";
import grid from "./grid";
import store from "store/store";

export default (selector, options) => {
    return SiteLogbookItem.renderTable(selector, grid(options), {
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
