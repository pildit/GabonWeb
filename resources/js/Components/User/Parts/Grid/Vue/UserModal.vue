<template>
    <bmodal ref="userModal" size="medium" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold">{{translate('add_user')}}</h4>
        </div>
        <div slot="body">
            <user-form ref="userForm" @done="closeModal"></user-form>
        </div>
        <div slot="footer">
            <button @click="submit" class="btn btn-default">{{ translate('save') }}</button>
            <button @click="closeModal"class="btn btn-warning">{{ translate('cancel') }}</button>
        </div>
    </bmodal>
</template>

<script>

import bmodal from 'components/Common/BootstrapModal.vue';
import UserForm from "components/User/Parts/Form/Vue/UserForm.vue";

export default {
    model: {
        prop: 'state',
        event: 'display'
    },

    props: ['state'],



    components: {bmodal, UserForm},

    methods: {
        submit() {
            this.$refs.userForm.save();
        },
        closeModal() {
            this.$refs.userModal.close();
            this.$emit('done');
        }
    },
    watch: {
        state(val) {
            if(!val) return;
            this.$refs.userForm.form = {};
            this.$refs.userForm.errors.clear();
            this.$refs.userModal.open();
        }
    }

}
</script>

<style scoped>

</style>
