<template>
    <div>
        <a v-permission="'AAC.edit'" :href="editRoute()" class="text-success aligned fz-16"
           :title="translate('edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <switches v-permission="'AAC.approve'" v-model="isApproved" color="green" :title="translate('approve_item')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import AAC from "components/Management/AAC/AAC";
import Notification from "components/Common/Notifications/Notification";

export default {
    props: ["rowProp", "optionsProp"],

    components: {Switches},

    data() {
        return {
            isApproved: this.rowProp.Approved
        }
    },

    methods: {
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
