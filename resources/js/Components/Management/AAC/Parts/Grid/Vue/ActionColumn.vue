<template>
    <div>
        <a v-permission="'AAC.edit'" :href="editRoute()" class="text-success aligned fz-16"
           :title="translate('edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <switches v-permission="'AAC.approve'" v-model="rowProp.Approved" color="green" :title="translate('approve_item')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
        <a v-permission="'AAC.delete'" @click.prevent="deleteAAC" href="#" class="text-danger aligned fz-16"
           :title="translate('delete')"
           v-tooltip>
            <i class="fas fa-trash"></i>
        </a>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import AAC from "components/Management/AAC/AAC";
import Notification from "components/Common/Notifications/Notification";
import Confirmation from "../../../../../Common/Confirmation/Confirmation";

export default {
    props: ["rowProp", "optionsProp"],

    components: {Switches},

    methods: {
        deleteAAC () {
            return Confirmation(this.translate('corfirmation_delete_question')).then((result) => {
                if(result.isConfirmed) {
                    AAC.delete(this.rowProp.Id).finally(() => {
                        Vent.$emit('grid-refresh')
                    })
                }
            })

        },

        editRoute() {
            return AAC.buildRoute('aac.edit', {id: this.rowProp.Id});
        },

        approve(value) {
            AAC.approve(this.rowProp.Id, {Approved: value}).then((response) => {
                Notification.success(this.translate('aac'), response.message);
                this.rowProp.Approved = value;
            });
        }
    }

}
</script>

<style scoped>

</style>
