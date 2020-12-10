<template>
    <div>
        <switches v-permission="'AACInventory.approve'"
                  v-model="rowProp.Approved" color="green"
                  :title="translate('approve_item')"
                  @input="approve"
                  :emit-on-mount="false" v-tooltip>
        </switches>
        <a href="#" class="text-danger fz-16" @click.prevent="deleteInventory">
            <i class="fas fa-trash"></i>
        </a>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import AAC from "components/Management/AAC/AAC";
import Notification from "components/Common/Notifications/Notification";

export default {
    props: ["rowProp", "optionsProp"],

    components: { Switches },

    methods: {
        deleteInventory () {
            AAC.delete_inventory(this.rowProp.id).finally(() => {
                Vent.$emit('grid-refresh')
            })
        },
        approve(value) {
            AAC.approveInventory(this.rowProp.Id, {Approved: value}).then((response) => {
                Notification.success(this.translate('aac'), response.message);
                this.rowProp.Approved = value;
            });
        }
    }
}
</script>

<style scoped>

</style>
