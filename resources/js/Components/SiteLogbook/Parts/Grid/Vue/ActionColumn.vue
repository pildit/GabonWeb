<template>
    <div class="text-right">
        <a v-permission="'site_logbook.view'" class="btn btn-sm btn-outline-info" :href="'/sitelogbook?Logbook=' + rowProp.Id" target="_blank"><i class="fas fa-info-circle"></i> {{translate('view')}}</a>
        <switches v-permission="'site_logbook.approve'" v-model="isApproved" color="green" :title="translate('approve_site_logbook')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
    import Switches from 'vue-switches';
    import SiteLogbook from "components/SiteLogbook/SiteLogbook";

    export default {

        props: ["rowProp", "optionsProp"],

        components: {Switches},
        computed: {
            isApproved: {
                get() {
                    return this.rowProp.Approved
                },
                set(value) {
                    return value;
                }
            }
        },

        methods: {
            approve (val) {
                SiteLogbook.approve(this.rowProp.Id, {Approved: val}).finally(() => this.rowProp.Approved = val);
            }
        }
    }
</script>

<style scoped>

</style>
