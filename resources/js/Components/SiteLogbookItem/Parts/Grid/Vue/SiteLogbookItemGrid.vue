<template>
    <div class="container mt-40">
        <h5 class="text-center green-text mb-2">{{translate('site_logbooks')}}</h5>
        <div class="row" v-permission="'site_logbook.view'">
            <div class="col-sm-6 d-flex align-items-center">

            </div>
            <div class="md-form col-sm-6">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="aac_name">{{translate('search')}}</label>
                        <input @keyup.enter="getSiteLogbooks" class="form-control" v-model="search" type="text" Placeholder="" name="aac_name" id="aac_name" />
                    </div>
                    <button @click="getSiteLogbooks" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <grid v-if="grid" v-permission="'site_logbook.view'" :columns="grid.columns" :options="grid.options"></grid>
    </div>
</template>

<script>
    import {mapGetters, mapState, mapActions} from 'vuex';
    import VuePagination from "components/Common/Grid/VuePagination.vue";
    import SiteLogbook from "components/SiteLogbook/SiteLogbook";

    import grid from "../grid";
    import Grid from "components/Common/Grid/Grid";
    import Species from "../../../../Species/Species";

    export default {
        components: {VuePagination, Grid},
        params: ['id'],
        data() {
            return {
                grid: null,
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
            this.speciesList = Species.listSearch('', 500).then((response) => {
                this.grid = grid({speciesList: response.data});
            })
            this.getSiteLogbooks();
        },
        methods: {
            getSiteLogbooks() {
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
