<template>
    <div>
        <a :href="editRoute()" class="text-success aligned fz-16"
           :title="translate('Edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <switches v-model="isApproved" color="green" title="Approve Item" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import DevelopmentUnit from "components/Management/DevelopmentUnit/DevelopmentUnit";
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
            return DevelopmentUnit.buildRoute('development_units.edit', {id: this.rowProp.Id});
        },

        approve(value) {
            DevelopmentUnit.approve(this.rowProp.Id, {Approved: value}).then((response) => {
                Notification.success('Development Unit', response.message);
                this.rowProp.Approved = value;
            });
        }
    }

}
</script>

<style scoped>

</style>
