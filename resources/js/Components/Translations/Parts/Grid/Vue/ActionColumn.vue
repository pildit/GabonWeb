<template>
    <div class="text-right">
        <button class="btn btn-sm btn-outline-success" @click="editTranslation(rowProp.id)" v-if="rowProp.name != 'admin'">
            <i class="fas fa-edit"></i>
            {{translate('edit')}}
        </button>
        <translation-modal type-prop="edit" v-model="modals.form"></translation-modal>
    </div>
</template>

<script>
    import TranslationModal from "./TranslationModal";
    import Translation from "components/Translations/Translation";

    export default {

        props: ["rowProp", "optionsProp"],

        components: {TranslationModal},

        data() {
            return {
                modals: {
                    form: false
                }
            }
        },

        methods: {
            editTranslation(id) {
                Translation.get(id).then(() => { this.modals.form = true });
            }
        }
    }
</script>

<style scoped>

</style>
