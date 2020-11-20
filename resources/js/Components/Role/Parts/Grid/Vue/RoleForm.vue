<template>
   <div>
       <div class="md-form mb-5">
           <input type="text" v-model="form.name" id="name" name="name" class="form-control" v-validate="'required'">
           <label data-error="wrong" data-success="right" for="name" :class="{'active': form.name}">{{ translate('name') }}</label>
           <div v-show="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
       </div>

       <div class="md-form mb-4">
         <multiselect
             v-model="form.type"
             :options="employeeTypes"
             placeholder="Type"
             track-by="id"
             label="name"
             :allow-empty="true"
             :multiple="false"
             :taggable="true"
         ></multiselect>

       </div>

       <div class="md-form mb-4">
           <multiselect
               v-model="form.permissions"
               :options="permissions"
               placeholder="Permissions"
               track-by="id"
               label="name"
               :allow-empty="true"
               :multiple="true"
               :taggable="true"
           ></multiselect>
       </div>
   </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import {mapGetters, mapState} from 'vuex';
import Role from "components/Role/Role";


export default {

    components: {Multiselect},

    data() {
        return {
            form : {},
            permissionList: []
        }
    },

    computed: {
        ...mapGetters('role', ['permissions']),
        ...mapGetters('user', ['employeeTypes']),
    },

    methods: {
        save() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    let permissions = _.map(this.form.permissions, 'id');
                    Role.add({name: this.form.name, type: this.form.type.id, permissions: permissions}).then((response) => {
                        this.$emit('done');
                    }).catch((error) => {
                        if(error) {
                            this.$setErrorsFromResponse(error.data);
                        }
                    })
                }
            });
        },
        update() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    let permissions = _.map(this.form.permissions, 'id');
                    Role.update(this.form.id, {name: this.form.name, type: this.form.type.id, permissions: permissions}).then(() => {
                        this.$emit('done');
                    }).catch((error) => {
                        if(error) {
                            this.$setErrorsFromResponse(error.data);
                        }
                    })
                }
            })
        }
    },
}
</script>

<style scoped>

</style>
