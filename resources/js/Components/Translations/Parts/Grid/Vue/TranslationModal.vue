<template>
    <bmodal ref="translationsModal" size="medium" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold" v-if="typeProp === 'create'">{{ translate('add_translation') }}</h4>
            <h4 class="modal-title w-100 font-weight-bold" v-else>{{ translate('edit_translation') }}</h4>
        </div>
        <div slot="body">
            <translation-form ref="translationsForm" @done="closeModal"></translation-form>
        </div>
        <div slot="footer">
            <button @click="submit" class="btn btn-default">{{ translate('save') }}</button>
            <button @click="closeModal" class="btn btn-warning">{{ translate('cancel') }}</button>
        </div>
    </bmodal>
</template>

<script>

    import bmodal from 'components/Common/BootstrapModal.vue';
    import TranslationForm from "./TranslationForm";
    import {mapGetters} from 'vuex';

    export default {
        model: {
            prop: 'state',
            event: 'display'
        },


        props: ['state', 'typeProp'],

        components: {bmodal, TranslationForm},

        computed: {
            ...mapGetters('translation', ['translation'])
        },

        methods: {
            submit() {
                if(this.typeProp == 'create') {
                    this.$refs.translationsForm.save();
                }else{
                    this.$refs.translationsForm.update();
                }
            },
            closeModal() {
                this.$refs.translationsModal.close();
                this.$emit('done');
                Vent.$emit('grid-refresh');
            }
        },
        watch: {
            state(val) {
                if(!val) return;
                if(this.typeProp != 'create') {
                    this.$refs.translationsForm.form = this.translation;
                }else{
                    this.$refs.translationsForm.form = {};
                }
                this.$refs.translationsForm.errors.clear();
                this.$refs.translationsModal.open();
            }
        }
    }
</script>

<style scoped>
</style>
