<template>
    <div>
        <a v-permission="'concession.edit'" class="text-success aligned fz-16" :href="editRoute()"
           :title="translate('Edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <switches v-permission="'concession.approve'" v-model="isApproved" color="green" title="Approve Item" @input="approve" :emit-on-mount="false"
                  v-tooltip></switches>
        <a @click.prevent="deleteConcession" v-permission="'concession.delete'" class="text-danger aligned fz-16"
           :title="translate('delete')"
           v-tooltip>
            <i class="fas fa-trash"></i>
        </a>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import Notification from "components/Common/Notifications/Notification";
import Concession from "../../../Concession";
import Confirmation from "../../../../Common/Confirmation/Confirmation";

export default {
    props: ["rowProp", "optionsProp"],

    components: {Switches},

    data() {
        return {
            isApproved: this.rowProp.Approved,
        }
    },

    methods: {
        deleteConcession () {
            return Confirmation(this.translate('corfirmation_delete_question')).then((result) => {
                if(result.isConfirmed) {
                    Concession.delete(this.rowProp.Id).finally(() => {
                        Vent.$emit('grid-refresh')
                    })
                }
            })
        },
        editRoute() {
            return Concession.buildRoute('concessions.edit', {id: this.rowProp.Id});
        },
        approve(val) {
            let promise = Concession.approve(this.rowProp.Id, {Approved: val}).then((response) => {
                Notification.success(this.translate('concessions'), response.data.message)
                return response.data;
            });

            return promise.finally(() => this.rowProp.Approved = val);
        },
    }
}
</script>

<style scoped>

</style>
