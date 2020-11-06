<template>
    <div class="container mt-40">
        <h5 class="text-center green-text mb-2">{{translate('Roles')}}</h5>
        <div class="row">
            <div class="col-sm-8 d-flex align-items-center">
                <button class="btn btn-md" @click="addRole">
                    <i class="fas fa-plus-circle"></i> {{translate('Add Role')}}
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
                <thead class="green white-text table-hover">
                <tr>
                    <th  @click="sortBy('id')" scope="col" class="cursor-pointer">
                        {{translate('Id')}}
                        <span class="sortable">
                            <i v-if="showSort('id', 'asc')" class="fas fa-sort-up"></i>
                            <i v-if="showSort('id', 'desc')" class="fas fa-sort-down"></i>
                            <i v-if="!showSort('id', 'desc') && !showSort('id', 'asc')" class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th  @click="sortBy('name')"  scope="col" class="cursor-pointer">
                        {{translate('Role')}}
                        <span class="sortable">
                            <i v-if="showSort('name', 'asc')" class="fas fa-sort-up"></i>
                            <i v-if="showSort('name', 'desc')" class="fas fa-sort-down"></i>
                            <i v-if="!showSort('name', 'desc') && !showSort('name', 'asc')" class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th  @click="sortBy('type')" scope="col" class="cursor-pointer">
                        {{translate('Type')}}
                        <span class="sortable">
                            <i v-if="showSort('type', 'asc')" class="fas fa-sort-up"></i>
                            <i v-if="showSort('type', 'desc')" class="fas fa-sort-down"></i>
                            <i v-if="!showSort('type', 'desc') && !showSort('type', 'asc')" class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th  @click="sortBy('created_at')" scope="col" class="cursor-pointer">
                        {{translate('Date')}}
                        <span class="sortable">
                            <i v-if="showSort('created_at', 'asc')" class="fas fa-sort-up"></i>
                            <i v-if="showSort('created_at', 'desc')" class="fas fa-sort-down"></i>
                            <i v-if="!showSort('created_at', 'desc') && !showSort('created_at', 'asc')" class="fas fa-sort"></i>
                        </span>
                    </th>
                    <th scope="col" class="text-right">{{translate('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="role in roles">
                    <th scope="row">{{role.id}}</th>
                    <th>{{role.name}}</th>
                    <th>{{role.type}}</th>
                    <th>{{role.created_at}}</th>
                    <th class="text-right" v-if="role.name != 'admin'"><span class="btn btn-sm btn-outline-success" @click="editRole(role.id)"><i class="fas fa-edit"></i> {{translate('Edit')}}</span></th>
                </tr>
                </tbody>
            </table>
            <vue-pagination :pagination="rolesPagination" @paginate="getRoles()" :offset="offset"></vue-pagination>
        </div>
        <role-modal :type-prop="formType" v-model="modals.form" @done="getRoles"></role-modal>
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
            sort: {
                direction: "asc",
                field: "id"
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
        getRoles() {
            Role.index({
                page: this.rolesPagination.current_page,
                per_page: this.rolesPagination.per_page,
                sort: this.sort.direction,
                sort_fields: this.sort.field,
                search: this.search
            })
                .then((pagination) => {
                    this.rolesPagination = pagination;
                })
        },
        addRole() {
            this.formType = 'create';
            this.modals.form = true
        },
        editRole(id) {
            this.formType = 'edit';
            Role.get(id).then(() => this.modals.form = true);
        },
        sortBy(col) {
            this.sort.direction = this.sort.direction == 'asc' ? 'desc' : 'asc';
            this.sort.field = col;
            this.getRoles();
        },
        showSort(key, direction) {
            return this.sort.field == key && this.sort.direction == direction;
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
