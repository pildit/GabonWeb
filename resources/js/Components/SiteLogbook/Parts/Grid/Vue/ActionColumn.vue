<template>
    <div class="text-right">
        <a v-permission="'site_logbook.view'" v-if="rowProp.items_count" class="text-info aligned fz-16" :href="'/sitelogbook?Logbook=' + rowProp.Id" target="_blank" :title="translate('view')" v-tooltip>
            <i class="fas fa-info-circle"></i>
        </a>
        <a v-permission="'site_logbook.view'" v-if="!rowProp.items_count" class="text-muted aligned fz-16" :title="translate('no_site_logbook_rows')" v-tooltip>
            <i class="fas fa-info-circle"></i>
        </a>
        <switches v-permission="'site_logbook.approve'" v-model="isApproved" color="green" :title="translate('approve_site_logbook')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
        <a v-permission="'site_logbook.delete'" @click="deleteItem" class="text-danger aligned fz-16" href="#" target="_blank" :title="translate('delete')" v-tooltip>
            <i class="fas fa-trash"></i>
        </a>
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
            deleteItem () {
                SiteLogbook.delete(this.rowProp.Id).finally(() => {
                    Vent.$emit('grid-refresh')
                })
            },
            approve (val) {
                SiteLogbook.approve(this.rowProp.Id, {Approved: val}).finally(() => this.rowProp.Approved = val);
            }
        }
    }
</script>

<style scoped>

</style>
