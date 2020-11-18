<template>
    <div class="text-right">
        <span class="btn btn-sm btn-outline-success" @click="edit()" ><i class="fas fa-edit"></i> {{translate('edit')}}</span>
        <permit-types-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form"></permit-types-modal>
    </div>
</template>

<script>
import permitTypesModal from "./PermitTypesModal";

export default {

    props: ["rowProp", "optionsProp"],

    components: {permitTypesModal},

    data() {
        return {
            modals: {
                form: false
            }
        }
    },

    methods: {
        edit() {
            this.modals.form = true;
        }
    }
}

</script>

<style scoped>

</style>
