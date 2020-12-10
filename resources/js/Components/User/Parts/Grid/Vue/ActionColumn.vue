<template>
    <div class="text-right">
        <a v-permission="'users.edit'" :href="editRoute()" class="text-success aligned fz-16"
           :title="translate('edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <a v-if="rowProp.status == 1" class="text-success aligned fz-16"
           :title="translate('resend_confirmation_email')"
           @click="resendConfirmation"
           v-tooltip >
            <span v-if="resendLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i v-else class="far fa-envelope"></i>
        </a>
        <switches v-permission="'users.approve'" v-model="rowProp.Approved" color="green" :title="translate('approve_user')" @input="approve" :emit-on-mount="false" v-tooltip></switches>

        <a v-permission="'users.delete'" @click="deleteUser" href="#" class="text-danger aligned fz-16"
           :title="translate('delete')"
           v-tooltip>
            <i class="fas fa-trash"></i>
        </a>
    </div>
</template>

<script>
import User from "components/User/User";

import Switches from 'vue-switches';
import Confirmation from "../../../../Common/Confirmation/Confirmation";

export default {



    props: ["rowProp", "optionsProp"],

    components: {Switches},

    data() {
        return {
            resendLoading: false
        }
    },

    computed: {
        isApproved: {
            get() {
                return this.rowProp.status == 2
            },
            set(value) {
                return value;
            }
        }
    },

    methods: {
        deleteUser() {
            return Confirmation(this.translate('corfirmation_delete_question')).then((result) => {
                if(result.isConfirmed) {
                    User.delete(this.rowProp.id).finally(() => {
                        Vent.$emit('grid-refresh')
                    })
                }
            })
        },
        editRoute() {
            return User.buildRoute('users.edit', {id: this.rowProp.id});
        },
        approve(val) {
            let promise = val ? User.approve(this.rowProp.id) : User.update(this.rowProp.id, {status: 3});

            return promise.finally(() => this.rowProp.status = val ? 2 : 3);
        },
        resendConfirmation() {
            this.resendLoading = true;
            User.resendConfirmation(this.rowProp.id).finally(() => this.resendLoading = false);
        }
    },

}
</script>

<style scoped>

</style>
