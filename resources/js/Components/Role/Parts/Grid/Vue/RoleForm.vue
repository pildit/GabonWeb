<template>
   <div>
       <div class="md-form mb-5">
           <input type="text" v-model="form.name" name="name" class="form-control" v-validate="'required'">
           <label data-error="wrong" data-success="right" for="name">{{ translate('name') }}</label>
           <div v-show="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
       </div>

       <div class="md-form mb-5">
           <input type="text" v-model="form.type" name="type" class="form-control" v-validate="'required'">
           <label data-error="wrong" data-success="right" for="type">{{ translate('type') }}</label>
           <div v-show="errors.has('type')" class="invalid-feedback">{{ errors.first('type') }}</div>
       </div>

       <div class="md-form mb-4">
           <multiselect
               v-model="form.permissions"
               :options="permissions"
               placeholder="Permissions"
               track-by="id"
               label="name"
               :allow-empty="false"
               :multiple="true"
               :taggable="true"
           ></multiselect>
       </div>
   </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import Multiselect from "vue-multiselect";
import {mapGetters} from 'vuex';
import Role from "components/Role/Role";


export default {
    props: ['typeProp'],

    mixins: [Translation],

    components: {Multiselect},

    data() {
        return {
            form : {},
        }
    },

    computed: {
        ...mapGetters('role', ['permissions']),
        isCreateType() {
            return this.typeProp == 'create'
        }
    },

    created() {
        console.log('here');
    },

    methods: {
        save() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    this.form.permissions = _.map(this.form.permissions, 'id');
                    Role.add(this.form).then((response) => {
                        this.closeModal();
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
                    this.form.permissions = _.map(this.form.permissions, 'id');
                    Role.update(this.form.id, this.form).then(() => {
                        this.closeModal();
                    }).catch((error) => {
                        if(error) {
                            this.$setErrorsFromResponse(error.data);
                        }
                    })
                }
            })
        },
        closeModal() {
            this.$refs.roleForm.close();
        }
    },
}
</script>

<style scoped>

</style>
