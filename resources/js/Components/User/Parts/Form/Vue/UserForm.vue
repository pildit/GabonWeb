<template>
    <div>
        <div class="md-form mb-5 ">
            <label for="firstname" :class="{'active': form.firstname}">{{translate('Firstname')}}</label>
            <input type="text"
                   v-model="form.firstname"
                   v-validate="'required'"
                   :data-vv-as="translate('firstname')"
                   class="form-control notempty"
                   name="firstname"
                   id="firstname"/>
            <div v-show="errors.has('firstname')" class="invalid-feedback">{{ errors.first('firstname') }}</div>
        </div>
        <div class="md-form mb-5 ">
            <label for="lastname" :class="{'active': form.lastname}">{{translate('Lastname')}}</label>
            <input type="text"
                   v-model="form.lastname"
                   v-validate="'required'"
                   :data-vv-as="translate('lastname')"
                   class="form-control notempty"
                   name="lastname"
                   id="lastname"/>
            <div v-show="errors.has('lastname')" class="invalid-feedback">{{ errors.first('lastname') }}</div>
        </div>
        <div class="md-form mb-5">
            <label for="email" :class="{'active': form.email}">{{translate('Email')}}</label>
            <input type="email"
                   v-model="form.email"
                   v-validate="'required|email'"
                   :data-vv-as="translate('email')"
                   class="form-control notempty"
                   name="email"
                   id="email"/>
            <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
        </div>
        <div v-if="isEditType" class="md-form mb-5">
            <label>{{translate('Company')}}</label>
            <multiselect
                v-model="form.company"
                :options="companyList.data"
                :placeholder="translate('Company')"
                track-by="Id"
                label="Name"
                :hide-selected="true"
                :options-limit="50"
                :searchable="true"
                :loading="companyList.isLoading"
                :allow-empty="false"
                @search-change="asyncFindCompany"
            ></multiselect>
        </div>
        <div v-if="isEditType" class="md-form mb-5">
            <label>{{translate('Employee Type')}}</label>
            <multiselect
                v-model="form.employee_type"
                :options="employeeTypes"
                :placeholder="translate('Employee Type')"
                track-by="id"
                label="name"
                :allow-empty="false"
            ></multiselect>
        </div>
        <div v-if="isEditType" class="md-form mb-5">
            <label>{{translate('Roles')}}</label>
            <multiselect
                v-model="form.roles"
                :options="roles"
                placeholder="Roles"
                track-by="id"
                label="name"
                :allow-empty="true"
                :multiple="true"
                :taggable="true"
            ></multiselect>
        </div>
        <div v-if="isEditType" class="md-form mb-5">
            <label>{{translate('Permissions')}}</label>
            <multiselect
                v-model="form.permissions"
                :options="permissionList"
                placeholder="Permissions"
                track-by="id"
                label="name"
                :allow-empty="true"
                :multiple="true"
                :taggable="true"
            ></multiselect>
            <div class="text-muted">{{translate('additional_permissions')}}</div>
        </div>
        <div v-if="showRoleName" class="md-form mb-5 ">
            <label for="role" :class="{'active': form.role}">{{translate('Role')}}</label>
            <input type="text"
                   v-model="form.role"
                   v-validate="{required: this.form.permissions.length > 0}"
                   :data-vv-as="translate('Role')"
                   class="form-control notempty"
                   name="role"
                   id="role"/>
            <div class="text-muted">{{translate('additional_role_info')}}</div>
            <div v-show="errors.has('role')" class="invalid-feedback">{{ errors.first('role') }}</div>
        </div>
        <div class="md-form mb-5">
            <label for="password" :class="{'active': form.password}">{{translate('Password')}}</label>
            <input type="password"
                   ref="password"
                   v-model="form.password"
                   v-validate="{required: !this.isEditType}"
                   :data-vv-as="translate('password')"
                   class="form-control"
                   name="password"
                   id="password"  />
            <div v-show="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>
        </div>
        <div class="md-form mb-5">
            <label for="confirm_password" :class="{'active': form.confirm_password}">{{translate('Confirm password')}}</label>
            <input type="password"
                   v-model="form.password_confirmation"
                   v-validate="form.password ? 'required|confirmed:password' : 'confirmed:password'"
                   :data-vv-as="translate('password_confirmation')"
                   class="form-control"
                   name="confirm_password"
                   id="confirm_password"  />
            <div v-show="errors.has('confirm_password')" class="invalid-feedback">{{ errors.first('confirm_password') }}</div>
        </div>
        <div v-if="isEditType" class="text-right">
            <button @click="update()" class="btn btn-default">{{ translate('Save') }}</button>
            <a :href="usersRoute()"class="btn btn-warning">{{ translate('Cancel') }}</a>
        </div>
    </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import User from "components/User/User";
import Company from "components/Company/Company";
import {mapState} from 'vuex';
import Multiselect from 'vue-multiselect'

export default {
    mixins: [Translation],

    props: ['typeProp', 'userProp'],

    components: { Multiselect },

    data() {
        return {
            form: {},
            companyList: {
                data: [],
                isLoading: false,
                limit: 50
            },
            showRoleName: false
        }
    },

    computed: {
        ...mapState('user', ['employeeTypes']),
        ...mapState('role', ['permissions', 'roles']),
        isEditType() {
            return this.typeProp == 'edit';
        },
        permissionList() {
            return _.filter(this.$diffObj(this.permissions, this.userProp.permissions));
        }
    },

    mounted() {
        if(this.isEditType) {
            let user = Object.assign({}, this.userProp);
            delete user.permissions;
            this.form = user;
            this.asyncFindCompany('');
        }
    },

    methods: {
        save() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    User.add(this.form).then(() => {
                        this.$emit('done');
                    }).catch((error) => {
                        if(error) {
                            this.$setErrorsFromResponse(error.data);
                        }
                    })
                }
            })
        },

        update() {
            this.$validator.validate();

        },

        usersRoute() {
            return User.buildRoute('users.index');
        },

        asyncFindCompany(query) {
            this.companyList.isLoading = true;
            Company.listSearch(query, this.companyList.limit).then((response) => {
                this.companyList.data= response.data;
                this.companyList.isLoading = false;
            })
        }

    },

    watch: {
        "form.permissions": {
            deep: true,
            handler(val) {
                this.showRoleName = (val && val.length) ? true : false;
            }
        },
    }

}
</script>

<style scoped>

</style>
