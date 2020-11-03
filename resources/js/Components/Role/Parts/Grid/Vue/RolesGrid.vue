<template>
    <div class="container mt-40">
        <h5 class="text-center green-text mb-40">{{translate('Roles')}}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="black white-text table-hover">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Role</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="role in roles.data">
                    <th scope="row">{{role.id}}</th>
                    <th>{{role.name}}</th>
                    <th>{{role.created_at}}</th>
                    <th v-if="role.name != 'admin'"><span class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i> Edit Permissions</span></th>
                    <th v-else><span class="btn btn-sm btn-outline-success"><i class="fas fa-plus"></i> Add Permissions</span></th>
                </tr>
                </tbody>
            </table>
            <vue-pagination :pagination="roles" @paginate="getRoles()" :offset="offset"></vue-pagination>
        </div>
    </div>
</template>

<script>
import VuePagination from "components/Common/VuePagination";
import Translation from "components/Mixins/Translation";
import Role from "components/Role/Role";

export default {
    mixins: [Translation],
    data() {
        return {
            roles: {
                total: 0,
                per_page: 20,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 4
        }
    },
    components: {VuePagination},
    mounted() {
      this.getRoles();
    },
    methods: {
        updateResource() {
            console.log('UPDATE RES');
        },
        getRoles() {
          Role.index({page: this.roles.current_page, per_page: this.roles.per_page, sort: 'asc'})
            .then((pagination) => {
                this.roles = pagination;
            })
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
