<template>
    <div class="text-right">
        <a v-permission="'species.edit'" class="text-success aligned fz-16" @click="edit(rowProp.id)" :title="translate('edit')" v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <species-modal v-permission="'species.edit'" :row-prop="rowProp" type-prop="edit" v-model="modals.form"></species-modal>
    </div>
</template>

<script>
import speciesModal from "./SpeciesModal";
import Species from "components/Species/Species";

export default {

    props: ["rowProp", "optionsProp"],

    components: {speciesModal},

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
