<template>
    <div class="container mt-40">
        <h5 class="text-center green-text mb-2">{{translate('Roles')}}</h5>
        <div class="row">
            <div class="col-sm-8 d-flex align-items-center">
                <button class="btn btn-md" @click="modals.form = true">
                    <i class="fas fa-plus-circle"></i> Add Role
                </button>
            </div>
            <div class="md-form col-sm-4">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="role_name">{{translate('Search')}}</label>
                        <input @keyup.enter="getRoles" class="form-control" v-model="search" type="text" Placeholder="" name="role_name" id="role_name" />
                    </div>
                    <button @click="getRoles" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="black white-text table-hover">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Role</th>
                    <th scope="col">Date</th>
                    <th scope="col" class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="role in roles">
                    <th scope="row">{{role.id}}</th>
                    <th>{{role.name}}</th>
                    <th>{{role.created_at}}</th>
                    <th class="text-right" v-if="role.name != 'admin'"><span class="btn btn-sm btn-outline-success" @click="editRole(role.id)"><i class="fas fa-edit"></i> Edit</span></th>
                </tr>
                </tbody>
            </table>
            <vue-pagination :pagination="rolesPagination" @paginate="getRoles()" :offset="offset"></vue-pagination>
        </div>
        <role-modal :type-prop="formType" v-model="modals.form"></role-modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Translation from "components/Mixins/Translation";
import RoleModal from './RoleModal.vue';
import Role from "components/Role/Role";

export default {
    mixins: [Translation],
    components: {VuePagination, RoleModal},
    data() {
        return {
            modals: {
                form: false
            },
            formType: 'create',
            rolesPagination: {
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
      ...mapGetters('role', ['roles'])
    },
    mounted() {
      this.getRoles();
      this.$store.dispatch('role/permissions');
    },
    methods: {
        updateResource() {
            console.log('UPDATE RES');
        },
        getRoles() {
            Role.index({page: this.rolesPagination.current_page, per_page: this.rolesPagination.per_page, sort: 'asc', search: this.search})
                .then((pagination) => {
                    this.rolesPagination = pagination;
                })
        },
        editRole(id) {
            this.formType = 'edit';
            Role.get(id).then(() => this.modals.form = true);
        }
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
