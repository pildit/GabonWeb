<template>
    <div class="text-right">
        <a v-permission="'parcels.edit'" class="text-success aligned fz-16" :href="editRoute()" :title="translate('edit')" v-tooltip><i class="fas fa-edit"></i></a>
        <switches v-permission="'parcels.approve'" v-model="isApproved" color="green" :title="translate('approve_item')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
        <a v-permission="'parcels.delete'" class="text-danger aligned fz-16" @click.prevent="deleteParcel" href="#" :title="translate('delete')" v-tooltip>
            <i class="fas fa-trash"></i></a>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import Notification from "components/Common/Notifications/Notification";

import Parcel from "../../../Parcel";

export default {

    props: ["rowProp", "optionsProp"],

    components: {Switches},

    data() {
        return {
          isApproved: this.rowProp.Approved
        }
    },

    methods: {
      deleteParcel () {
          Parcel.delete(this.rowProp.Id).finally(() => {
              Vent.$emit('grid-refresh')
          })
      },

      editRoute() {
        return Parcel.buildRoute('parcels.edit', {id: this.rowProp.Id});
      },
      approve(val) {
        let promise =  Parcel.approve(this.rowProp.Id, {Approved: val}).then((response) => {
          Notification.success(translate('parcel'), response.data.message)
          return response.data;
        });

        return promise.finally(() => this.rowProp.Approved = val);
      },
    }
}

</script>

<style scoped>

</style>
