<template>
    <div class="text-right">
        <a class="text-success aligned fz-16" :href="editRoute()"
           :title="translate('Edit')"
           v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <switches v-model="isApproved" color="green" title="Approve Item" @input="approve" :emit-on-mount="false"
                  v-tooltip></switches>
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
            modals: {
                form: false
            }
        }
    },

    methods: {
        editRoute() {
            return ConstituentPermit.buildRoute('constituent_permits.edit', {id: this.rowProp.Id});
        },
        approve(val) {
            let promise = ConstituentPermit.update(this.rowProp.Id, {approved: val}).then((response) => {
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
