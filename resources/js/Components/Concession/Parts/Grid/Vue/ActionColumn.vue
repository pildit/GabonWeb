<template>
    <div>
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
import Concession from "../../../Concession";

export default {
    props: ["rowProp", "optionsProp"],

    components: {Switches},

    data() {
        return {
            isApproved: this.rowProp.Approved,
        }
    },

    methods: {
        editRoute() {
            return Concession.buildRoute('concessions.edit', {id: this.rowProp.Id});
        },
        approve(val) {
            let promise = Concession.approve(this.rowProp.Id, {Approved: val}).then((response) => {
                Notification.success(this.translate('concessions'), response.data.message)
                return response.data;
            });

            return promise.finally(() => this.rowProp.Approved = val);
        },
    }
}
</script>

<style scoped>

</style>
