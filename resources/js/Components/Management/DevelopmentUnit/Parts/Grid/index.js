import DevelopmentUnit from "../../DevelopmentUnit";
import axios from 'axios';
import store from "store/store";
import grid from './grid';
import DateRange from "components/Mixins/DateRange";
import Export from "components/Mixins/ExportExcel";

export default (selector, options) => {
    return DevelopmentUnit.renderTable(selector, grid(options), {
        store,
        mixins: [DateRange, Export],
        data: {
            sort: {
                direction: "asc",
                field: "id"
            },
            search: null,
            exportUrl: '/api/development_units/export',
            exportFilename: 'Development Units'
        },
        methods: {
            fetchData() {
                Vent.$emit('grid-refresh', {search: this.search, dateRange: this.dateRange});
            },
            createRoute() {
                return DevelopmentUnit.buildRoute('development_units.create');
            },
        }
    });
}
