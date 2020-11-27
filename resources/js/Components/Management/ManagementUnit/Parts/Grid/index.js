import ManagementUnit from "../../ManagementUnit";
import grid from "./grid";
import store from "store/store";
import DateRange from "components/Mixins/DateRange";
import Export from "components/Mixins/ExportExcel";

export default (selector, options) => {
    return ManagementUnit.renderTable(selector, grid(options), {
        store,
        mixins: [DateRange, Export],
        data: {
            sort: {
                direction: "asc",
                field: "id"
            },
            search: null,
            exportUrl: '/api/management_units/export',
            exportFilename: 'Management Units'
        },
        methods: {
            fetchData() {
                Vent.$emit('grid-refresh', {search: this.search, dateRange: this.dateRange});
            },
            createRoute() {
                return ManagementUnit.buildRoute('management_units.create');
            }
        }
    })
}
