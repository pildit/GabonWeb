<template>
    <div class="text-right">
        <a v-permission="'parcels.edit'" class="text-success aligned fz-16" @click="edit()" :title="translate('edit')" v-tooltip><i class="fas fa-edit"></i></a>
        <item-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form"></item-modal>
        <switches v-permission="'parcels.approve'" v-model="isApproved" color="green" :title="translate('approve_item')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import Notification from "components/Common/Notifications/Notification";

import itemModal from "./ItemModal";
import Item from "../../../Parcel";

export default {

    props: ["rowProp", "optionsProp"],

    components: {itemModal, Switches},

    data() {
        return {
          isApproved: this.rowProp.Approved,
          modals: {
                form: false
            }
        }
    },

    methods: {
        edit() {
            this.modals.form = true;
        },
      approve(val) {
        let promise =  Item.approve(this.rowProp.Id, {Approved: val}).then((response) => {
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
