import AAC from "../../AAC";
import grid from "./grid";
import store from "store/store";
import DateRange from "components/Mixins/DateRange";
import Export from "components/Mixins/ExportExcel";

export default (selector, options) => {
    return AAC.renderTable(selector, grid(options), {
        store,
        mixins: [DateRange, Export],
        data: {
            sort: {
                direction: "asc",
                field: "id"
            },
            search: null,
            exportUrl: '/api/annual_allowable_cut_inventory/export',
            exportFilename: 'Annual Allowable Cuts Inventory'
        },
        methods: {
            fetchData() {
                Vent.$emit('grid-refresh', {search: this.search, dateRange: this.dateRange});
            },
        }
    })
}
