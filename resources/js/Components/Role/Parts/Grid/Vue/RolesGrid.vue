<template>
    <div class="container mt-5">
        <h5 class="text-center green-text mb-2">{{ translate('roles') }}</h5>
        <div class="row">
            <div class="col-sm-8 d-flex align-items-center">
                <button class="btn btn-md" @click="modals.form = true">
                    <i class="fas fa-plus-circle"></i> {{translate('add_role')}}
                </button>
            </div>
            <div class="md-form col-sm-4">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="role_name">{{ translate('search') }}</label>
                        <input @keyup.enter="getRoles" class="form-control" v-model="search" type="text"  name="role_name" id="role_name" />
                    </div>
                    <button @click="getRoles" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <grid :columns="grid.columns" :options="grid.options"></grid>
        <role-modal :type-prop="formType" v-model="modals.form" @done="getRoles"></role-modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import RoleModal from './RoleModal.vue';
import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {
    components: {VuePagination, RoleModal, Grid},
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
      ...mapGetters('role', ['roles']),

    },
    mounted() {
      this.getRoles();
      this.$store.dispatch('role/permissions');
      this.$store.dispatch('user/types');
    },
    methods: {
        getRoles() {
          Vent.$emit('grid-refresh', {search: this.search});
        }
    }
}
</script>

<style scoped>
.mt-40 {
    margin-top: 40px;
}
.sortable {
    padding-left: 5px;
}
.cursor-pointer {
    cursor: pointer;
}
</style>
