<template>
    <div class="container mt-40" v-permission="'logbook.view'" >
        <h5 class="text-center green-text mb-2">{{translate('logbooks')}}</h5>
        <div class="row"  v-permission="'logbook.view'">
            <div class="col-sm-6 d-flex align-items-center">

            </div>
            <div class="md-form col-sm-6">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="aac_name">{{translate('search')}}</label>
                        <input @keyup.enter="getlogbooks" class="form-control" v-model="search" type="text" Placeholder="" name="aac_name" id="aac_name" />
                    </div>
                    <button @click="getlogbooks" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <grid v-permission="'logbook.view'" :columns="grid.columns" :options="grid.options"></grid>
    </div>
</template>

<script>
    import {mapGetters, mapState, mapActions} from 'vuex';
    import VuePagination from "components/Common/Grid/VuePagination.vue";
    import Logbook from "components/Logbook/Logbook";

    import grid from "../grid";
    import Grid from "components/Common/Grid/Grid";

    export default {
        components: {VuePagination, Grid},
        data() {
            return {
                grid: grid(),
                modals: {
                    form: false
                },
                formType: 'create',
                logBookPagination: {
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
        computed: {
        },
        mounted() {
            this.getlogbooks();
        },
        methods: {
            getlogbooks() {
                Vent.$emit('grid-refresh', {search: this.search});
            },
        }
    }
</script>

<style scoped>
    .mt-40 {
        margin-top: 40px;
    }
    .mb-40 {
        margin-bottom: 40px;
    }
</style>
