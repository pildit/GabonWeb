<template>
    <div class="text-right">
        <a v-permission="'translations.edit'" class="text-success aligned fz-16" @click="editTranslation(rowProp.id)" v-if="rowProp.name != 'admin'"
                :title="translate('edit')" v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <translation-modal v-permission="'translations.edit'" type-prop="edit" v-model="modals.form"></translation-modal>
        <a v-permission="'translations.delete'" class="text-danger aligned fz-16" @click.prevent="deleteTranslation"
           :title="translate('delete')" v-tooltip>
            <i class="fas fa-trash"></i>
        </a>
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
            deleteTranslation () {
                Translation.delete(this.rowProp.id).finally(() => {
                    Vent.$emit('grid-refresh')
                })
            },
            editTranslation(id) {
                Translation.get(id).then(() => { this.modals.form = true });
            }
        }
    }
</script>

<style scoped>

</style>
