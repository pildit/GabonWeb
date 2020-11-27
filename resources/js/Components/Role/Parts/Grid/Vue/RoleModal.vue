<template>
    <bmodal ref="roleModal" size="medium" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold">{{ translate('add_role') }}</h4>
        </div>
        <div slot="body">
            <role-form ref="roleForm" @done="closeModal"></role-form>
        </div>
        <div slot="footer">
            <button @click="submit" class="btn btn-default">{{ translate('save') }}</button>
            <button @click="closeModal"class="btn btn-warning">{{ translate('cancel') }}</button>
        </div>
    </bmodal>
</template>

<script>
import bmodal from 'components/Common/BootstrapModal.vue';
import RoleForm from "./RoleForm";
import {mapGetters} from 'vuex';

export default {
    model: {
      prop: 'state',
      event: 'display'
    },

    props: ['state', 'typeProp'],

    components: {bmodal, RoleForm},

    computed: {
        ...mapGetters('role', ['role']),
        ...mapGetters('user', ['employeeTypes'])
    },

    methods: {
        submit() {
            if(this.typeProp == 'create') {
                this.$refs.roleForm.save();
            }else{
                this.$refs.roleForm.update();
            }
        },
        closeModal() {
            this.$refs.roleModal.close();
            this.$emit('done');
            Vent.$emit('grid-refresh');
        }
    },

    watch: {
        state(val) {
            if(!val) return;
            if(this.typeProp != 'create') {
                this.$refs.roleForm.form = this.role;
                this.$refs.roleForm.form.type = this.employeeTypes.find((x) => x.id == this.role.type);
            }else{
                this.$refs.roleForm.form = {};
            }
            this.$refs.roleForm.errors.clear();
            this.$refs.roleModal.open();
        }
    }
}
</script>

<style scoped>

</style>
