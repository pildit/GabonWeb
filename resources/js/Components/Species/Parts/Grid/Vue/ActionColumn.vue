<template>
    <div class="text-right">
        <span class="btn btn-sm btn-outline-success" @click="edit(rowProp.id)" ><i class="fas fa-edit"></i> {{translate('Edit')}}</span>
        <species-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form"></species-modal>
    </div>
</template>

<script>
import speciesModal from "./SpeciesModal";
import Translation from "components/Mixins/Translation";
import Species from "components/Species/Species";

export default {
    mixins: [Translation],

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
        edit(id) {
            this.modals.form = true;
        }
    }
}
</script>

<style scoped>

</style>
