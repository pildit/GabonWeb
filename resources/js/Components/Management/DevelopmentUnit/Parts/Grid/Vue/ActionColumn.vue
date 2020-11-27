<template>
    <div>
        <a v-permission="'development-unit.add'" :href="editRoute()" class="text-success aligned fz-16"
           :title="translate('edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <switches v-permission="'development-unit.approve'" :key="rowProp.Id" v-model="rowProp.Approved" color="green" :title="translate('approve_item')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import DevelopmentUnit from "components/Management/DevelopmentUnit/DevelopmentUnit";
import Notification from "components/Common/Notifications/Notification";

export default {
    props: ["rowProp", "optionsProp"],

    components: {Switches},

    methods: {
        editRoute() {
            return DevelopmentUnit.buildRoute('development_units.edit', {id: this.rowProp.Id});
        },

        approve(value) {
            DevelopmentUnit.approve(this.rowProp.Id, {Approved: value}).then((response) => {
                Notification.success(this.translate('development_unit'), response.message);
                this.rowProp.Approved = value;
            });
        }
    }

}
</script>

<style scoped>

</style>
