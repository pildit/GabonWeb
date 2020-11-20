<template>
    <div class="text-right">
        <a class="btn btn-sm btn-outline-info" :href="'/logbooks/' + rowProp.Id + '/print'" target="_blank"><i class="fas fa-info-circle"></i> {{translate('view')}}</a>
        <switches v-model="isApproved" color="green" :title="translate('approve_logbook')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
    </div>
</template>

<script>
    import Logbook from "components/Logbook/Logbook";
    import Switches from 'vue-switches';

    export default {

        props: ["rowProp", "optionsProp"],

        data() {
            return {
                modals: {
                    form: false
                }
            }
        },
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
            approve(val) {
                let promise = Logbook.approve(this.rowProp.Id);

                return promise.finally(() => this.rowProp.Approved = val);
            },
        }
    }
</script>

<style scoped>

</style>
