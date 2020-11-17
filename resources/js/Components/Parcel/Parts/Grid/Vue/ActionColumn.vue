<template>
    <div class="text-right">
        <span class="btn btn-sm btn-outline-success" @click="edit()" ><i class="fas fa-edit"></i> {{translate('Edit')}}</span>
        <item-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form"></item-modal>
        <switches v-model="isApproved" color="green" title="Approve Item" @input="approve" :emit-on-mount="false" v-tooltip></switches>
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
        let promise =  Item.update(this.rowProp.Id, {Approved: val}).then((response) => {
          Notification.success('Parcel', response.data.message)
          return response.data;
        });

        return promise.finally(() => this.rowProp.Approved = val);
      },
    }
}

</script>

<style scoped>

</style>
