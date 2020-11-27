<template>
    <div class="text-right">
        <a v-permission="'permit-types.edit'" class="text-success aligned fz-16" @click="edit()" :title="translate('edit')" v-tooltip >
            <i class="fas fa-edit"></i>
        </a>
        <permit-types-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form" :key="rowProp.Id"></permit-types-modal>
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
