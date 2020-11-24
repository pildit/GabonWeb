import store from "store/store";
import grid from './grid';
import ConstituentPermit from "../../ConstituentPermit";


export default (selector, options) => {
    return ConstituentPermit.renderTable(selector, grid(options), {
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
                return ConstituentPermit.buildRoute('constituent_permits.create');
            }
        }
    });

}
