<template>
    <div class="container-fluid mt-40" v-permission="'permit.view'">
        <div class="row">
            <div class="col-md-4">
                {{translate('the_map')}}
            </div>
            <div class="col-md-8">
                <h5 class="text-center green-text mb-2">{{translate('transport_permits')}}</h5>
                <div class="row">
                    <div class="col-sm-8 d-flex align-items-center">
                    </div>
                    <div class="md-form col-sm-4">
                        <div class="form-row justify-content-end">
                            <div class="col-sm-10">
                                <label for="role_name">{{translate('search')}}</label>
                                <input @keyup.enter="getPermits" class="form-control" v-model="search" type="text"  name="role_name" id="role_name" />
                            </div>
                            <button @click="getPermits" class="btn btn-sm btn-green  px-2" id="filter">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <grid :columns="grid.columns" :options="grid.options"></grid>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapState, mapActions} from 'vuex';
    import VuePagination from "components/Common/Grid/VuePagination.vue";

    import grid from "../grid";
    import Grid from "components/Common/Grid/Grid";

    export default {
        components: {VuePagination, Grid},
        data() {
            return {
                grid: grid(),
                permitPagination: {
                    total: 0,
                    per_page: 20,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                search: '',
            }
        },
        computed: {
            ...mapGetters('permit', ['permits']),
        },
        mounted() {
            this.getPermits();
        },
        methods: {
            getPermits() {
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
