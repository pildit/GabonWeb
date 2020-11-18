import DevelopmentUnit from "../../DevelopmentUnit";
import store from "store/store";
import grid from './grid';

export default (selector, options) => {
    return DevelopmentUnit.renderTable(selector, grid(options), {
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
                return DevelopmentUnit.buildRoute('development_units.create');
            }
        }
    });
}
