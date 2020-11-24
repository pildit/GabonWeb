import store from "store/store";
import grid from './grid';
import Concession from "../../Concession";

export default (selector, options) => {
    return Concession.renderTable(selector, grid(options), {
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
                return Concession.buildRoute('concessions.create');
            }
        }
    })
}
