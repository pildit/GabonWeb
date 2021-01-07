<template>
    <div>
        <switches v-permission="'management-unit.approve'" :key="rowProp.Id" v-model="rowProp.Approved" color="green" :title="translate('approve_item')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import ManagementPlan from "components/Management/ManagementPlan/ManagementPlan";
import Notification from "components/Common/Notifications/Notification";
import Confirmation from "../../../../../Common/Confirmation/Confirmation";

export default {
    props: ["rowProp", "optionsProp"],

    components: {Switches},

    methods: {
        approve(value) {
            ManagementPlan.approve(this.rowProp.Id, {Approved: value}).then((response) => {
                Notification.success(this.translate('management_plan'), response.message);
                this.rowProp.Approved = value;
            });
        }
    }

}
</script>

<style scoped>

</style>
