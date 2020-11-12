<template>
   <div>
       <div class="md-form mb-5">
           <input type="text" v-model="form.Name" name="name" class="form-control" v-validate="'required'">
           <label data-error="wrong" data-success="right" for="name" :class="{'active': form.Name}">{{ translate('name') }}</label>
           <div v-show="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
       </div>

       <div class="md-form mb-5">
           <input type="text" v-model="form.GroupName" name="groupName" class="form-control" >
           <label data-error="wrong" data-success="right" for="groupName" :class="{'active': form.GroupName}">{{ translate('groupName') }}</label>
           <div v-show="errors.has('groupName')" class="invalid-feedback">{{ errors.first('groupName') }}</div>
       </div>

       <div class="md-form mb-4">
           <multiselect
               v-model="form.types"
               :options="types"
               placeholder="Types"
               track-by="Id"
               label="Name"
               :allow-empty="false"
               :multiple="true"
               :taggable="true"
           ></multiselect>
       </div>
   </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import {mapGetters} from 'vuex';
import Company from "components/Company/Company";


export default {

    components: {Multiselect},

    data() {
        return {
            form : {},
        }
    },

    computed: {
        ...mapGetters('company', ['types']),
    },

    methods: {
        save() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    let types = _.map(this.form.types, 'Id');
                    Company.add({
                      name: this.form.Name,
                      'group-name': this.form.GroupName,
                      types: types
                    }).then((response) => {
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
                    let types = _.map(this.form.types, 'Id');
                    Company.update(this.form.Id, {
                      name: this.form.Name,
                      'group-name': this.form.GroupName,
                      types: types
                    }).then(() => {
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
