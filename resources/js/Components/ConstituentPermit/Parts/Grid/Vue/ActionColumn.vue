<template>
    <div class="text-right">
        <a v-permission="'constituent-permit.edit'" class="text-success aligned fz-16" :href="editRoute()"
           :title="translate('edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <switches v-permission="'constituent-permit.approve'" v-model="isApproved" color="green" title="Approve Item" @input="approve" :emit-on-mount="false"
                  v-tooltip></switches>

        <a v-permission="'constituent-permit.delete'" class="text-danger aligned fz-16" href="#"
           :title="translate('delete')"
           v-tooltip
        @click.prevent="deletePermit">
            <i class="fas fa-trash"></i>
        </a>
    </div>
</template>

<script>
import Switches from 'vue-switches';
import Notification from "components/Common/Notifications/Notification";
import ConstituentPermit from "components/ConstituentPermit/ConstituentPermit";

export default {

    props: ["rowProp", "optionsProp"],

    components: {Switches},

    data() {
        return {
            isApproved: this.rowProp.Approved,
        }
    },

    methods: {
        deletePermit () {
            ConstituentPermit.delete(this.rowProp.Id).finally(() => {
                Vent.$emit('grid-refresh')
            })
        },
        editRoute() {
            return ConstituentPermit.buildRoute('constituent_permits.edit', {id: this.rowProp.Id});
        },
        approve(val) {
            let promise = ConstituentPermit.approve(this.rowProp.Id, {Approved: val}).then((response) => {
                Notification.success('Constituent Permit', response.data.message)
                return response.data;
            });

            return promise.finally(() => this.rowProp.Approved = val);
        },

    }
}

</script>

<style scoped>

</style>
