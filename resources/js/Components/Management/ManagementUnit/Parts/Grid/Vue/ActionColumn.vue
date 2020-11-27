<template>
    <div>
        <a v-permission="'management-unit.edit'" :href="editRoute()" class="text-success aligned fz-16"
           :title="translate('edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <switches v-permission="'management-unit.approve'" v-model="rowProp.Approved" color="green" :title="translate('approve_item')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import ManagementUnit from "components/Management/ManagementUnit/ManagementUnit";
import Notification from "components/Common/Notifications/Notification";

export default {
    props: ["rowProp", "optionsProp"],

    components: {Switches},

    methods: {
        editRoute() {
            return ManagementUnit.buildRoute('management_units.edit', {id: this.rowProp.Id});
        },

        approve(value) {
            ManagementUnit.approve(this.rowProp.Id, {Approved: value}).then((response) => {
                Notification.success(this.translate('management_unit'), response.message);
                this.rowProp.Approved = value;
            });
        }
    }

}
</script>

<style scoped>

</style>
