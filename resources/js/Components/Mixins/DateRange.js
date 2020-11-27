import DateRangePicker from 'vue2-daterange-picker'

export default {
    components: {DateRangePicker},
    data() {
        return {
            dateRange : {
                startDate: null,
                endDate: null
            }
        }
    },
    methods: {
        updateDates(values) {
            this.exportParams.date_from = moment(values.startDate).format('YYYY-MM-DD');
            this.dateRange.startDate = moment(values.startDate).format('YYYY-MM-DD');
            this.exportParams.date_to = moment(values.endDate).format('YYYY-MM-DD')
            this.dateRange.endDate = moment(values.endDate).format('YYYY-MM-DD')
        }
    },
}
