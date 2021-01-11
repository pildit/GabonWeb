<template>
    <div>
        <switches v-permission="'development-unit.approve'" :key="rowProp.Id" v-model="rowProp.Approved" color="green" :title="translate('approve_item')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import DevelopmentPlan from "components/Management/DevelopmentPlan/DevelopmentPlan";
import Notification from "components/Common/Notifications/Notification";
import Confirmation from "../../../../../Common/Confirmation/Confirmation";

export default {
    props: ["rowProp", "optionsProp"],

    components: {Switches},

    methods: {
        approve(value) {
            DevelopmentPlan.approve(this.rowProp.Id, {Approved: value}).then((response) => {
                Notification.success(this.translate('development_plan'), response.message);
                this.rowProp.Approved = value;
            });
        }
    }

}
</script>

<style scoped>

</style>
