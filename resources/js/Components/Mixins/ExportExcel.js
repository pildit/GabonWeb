import axios from "axios";

export default {
    data() {
        return {
            exportLoading: false,
            exportFilename: 'Export',
            exportParams: {}
        }
    },
    methods: {
        exportXLS() {
            this.exportLoading = true;
            axios({
                url: this.exportUrl,
                params: this.exportParams,
                method: 'GET',
                responseType: 'blob', // important
            }).then((response) => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `${this.exportFilename}.xlsx`);
                document.body.appendChild(link);
                link.click();
            }).finally(()=>this.exportLoading = false);
        }
    },
}
