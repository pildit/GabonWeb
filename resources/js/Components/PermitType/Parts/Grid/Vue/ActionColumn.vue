<template>
    <div class="text-right">
        <span class="btn btn-sm btn-outline-success" @click="edit(rowProp.id)" ><i class="fas fa-edit"></i> {{translate('Edit')}}</span>
        <permit-types-modal type-prop="edit" v-model="modals.form"></permit-types-modal>
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
}
</script>

<style scoped>

</style>
