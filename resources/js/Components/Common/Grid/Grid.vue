<template>

    <div class="grid" :ref="options.instance">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="green white-text table-hover">
                <tr>
                    <th v-for="(value, key) in columns" @click="sortBy(key)" :style="columnStyle(key)" scope="col" class="cursor-pointer">
                        {{translate(value.header)}}
                        <span class="sortable" v-if="canSort(key)">
                            <i v-if="showSort(key, 'asc')" class="fas fa-sort-up"></i>
                            <i v-if="showSort(key, 'desc')" class="fas fa-sort-down"></i>
                            <i v-if="!showSort(key, 'desc') && !showSort(key, 'asc')" class="fas fa-sort"></i>
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(row, index) in data">
                    <td v-for="(column, key) in columns" :style="columnStyle(key)">
                        <grid-cell :column-prop="column" :row-prop="row" :key-prop="key" :instance="options.instance" :index="index"></grid-cell>
                    </td>
                </tr>
                </tbody>
            </table>
            <vue-pagination :pagination="pagination" @paginate="fetchData()" :offset="offset"></vue-pagination>
        </div>
    </div>

</template>

<script>
import VuePagination from "./VuePagination";
import GridCell from "./GridCell";
import Translation from "../../Mixins/Translation";

export default {
    mixins: [Translation],

    props: ['options', 'columns'],

    components: {GridCell, VuePagination},

    data() {
        return {
            data: [],
            sort: {
                direction: "desc",
                field: "id"
            },
            formType: 'create',
            pagination: {
                total: 0,
                per_page: 20,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 4,
            search: null,
        }
    },

    mounted() {
        if(!this.options.store) {
            throw new Error('provide a store');
        }
        if(!this.options.store.getter) {
            throw new Error('provide a store getter');
        }
        if(this.options.sort) {
            this.sort = this.options.sort;
        }

        this.data = this.$store.getters[this.options.store.getter];
        this.fetchData();
        Vent.$on('grid-refresh', this.refresh.bind(this));
    },

    methods: {
        sortBy(col) {
            this.sort.direction = this.sort.direction == 'asc' ? 'desc' : 'asc';
            this.sort.field = col;
            this.fetchData();
        },
        showSort(key, direction) {
            return this.sort.field == key && this.sort.direction == direction;
        },
        canSort(key) {
            if(typeof this.columns[key]['sort'] === 'undefined') {
                return true;
            }

            return Boolean(this.columns[key]['sort']);
        },
        columnStyle(key) {
            let styles = this.columns[key].css || {};
            return Object.keys(styles).reduce((memo, value)=> {
                let prop = value.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
                return memo += `${prop}: ${styles[value]};`;
            }, "");
        },
        fetchData() {
            if(!this.options.store.action) {
                throw new Error('the options must contain an store');
            }

            let data = {
                page: this.pagination.current_page,
                per_page: this.pagination.per_page,
                sort: this.sort.direction,
                sort_fields: this.sort.field,
                search: this.search
            }

            this.$store.dispatch(this.options.store.action, data)
                .then((response) => response.data)
                .then((pagination) => {
                    this.pagination = pagination;
                    this.data = this.$store.getters[this.options.store.getter];
                });
        },
        refresh(payload) {
            if(payload && payload.hasOwnProperty('search')) {
                this.search = payload.search;
                this.pagination.current_page = 1;
            }
            this.fetchData();
        }
    }
}
</script>

<style scoped>

</style>
