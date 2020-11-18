<template>
    <div class="container mt-5">
        <h5 class="text-center green-text mb-2">{{translate('users')}}</h5>
        <div class="row">
            <div class="col-sm-8 d-flex align-items-center">
                <button class="btn btn-md" @click="modals.form = true">
                    <i class="fas fa-plus-circle"></i> {{translate('add_user')}}
                </button>
            </div>
            <div class="md-form col-sm-4">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="role_name">{{translate('search')}}</label>
                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text"  name="role_name" id="role_name" />
                    </div>
                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <grid :columns="grid.columns" :options="grid.options"></grid>
        <user-modal v-model="modals.form" @done="fetchData"></user-modal>
    </div>
</template>

<script>

import {mapGetters} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import grid from "../grid";
import Grid from "components/Common/Grid/Grid";
import UserModal from "./UserModal";

export default {


    components: {VuePagination, Grid, UserModal},

    data() {
        return {
            grid: grid(),
            modals: {
                form: false
            },
            sort: {
                direction: "asc",
                field: "id"
            },
            formType: 'create',
            search: null,
        }
    },
    computed: {
        ...mapGetters('user', ['users']),

    },
    mounted() {

    },
    methods: {
        fetchData() {
            Vent.$emit('grid-refresh', {search: this.search});
        }
    }
}
</script>

<style scoped>

</style>
