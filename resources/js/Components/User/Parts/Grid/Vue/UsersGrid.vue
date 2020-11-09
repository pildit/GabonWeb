<template>
    <div class="container mt-40">
        <h5 class="text-center green-text mb-2">{{translate('Users')}}</h5>
        <div class="row">
            <div class="col-sm-8 d-flex align-items-center">
                <button class="btn btn-md" @click="adUser">
                    <i class="fas fa-plus-circle"></i> {{translate('Add User')}}
                </button>
            </div>
            <div class="md-form col-sm-4">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="role_name">{{translate('Search')}}</label>
                        <input @keyup.enter="fetchData" class="form-control" v-model="search" type="text" Placeholder="" name="role_name" id="role_name" />
                    </div>
                    <button @click="fetchData" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="black white-text table-hover">
                <tr>
                    <th scope="col">{{translate('Id')}}</th>
                    <th scope="col">{{translate('Role')}}</th>
                    <th scope="col">{{translate('Type')}}</th>
                    <th scope="col">{{translate('Date')}}</th>
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
            <vue-pagination :pagination="rolesPagination" @paginate="fetchData()" :offset="offset"></vue-pagination>
        </div>
        <role-modal :type-prop="formType" v-model="modals.form" @done="fetchData"></role-modal>
    </div>
</template>

<script>
export default {

    methods: {

    }
}
</script>

<style scoped>

</style>
