<template>
    <div class="container mt-40">
        <h5 class="text-center green-text mb-2">{{ translate('translations') }}</h5>
        <div class="row">
            <div class="col-sm-8 d-flex align-items-center">
                <button class="btn btn-md" @click="modals.form = true">
                    <i class="fas fa-plus-circle"></i> {{translate('add_string') }}
                </button>
            </div>
            <div class="md-form col-sm-4">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="role_name">{{ translate('search') }}</label>
                        <input @keyup.enter="getTranslations" class="form-control" v-model="search" type="text"  name="role_name" id="role_name" />
                    </div>
                    <button @click="getTranslations" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <grid :columns="grid.columns" :options="grid.options"></grid>
        <translation-modal :type-prop="formType" v-model="modals.form" @done="getTranslations"></translation-modal>
    </div>
</template>

<script>
    import {mapGetters, mapState, mapActions} from 'vuex';
    import VuePagination from "components/Common/Grid/VuePagination.vue";
    import TranslationModal from "./TranslationModal";
    import Translation from "components/Translations/Translation"

    import grid from "../grid";
    import Grid from "components/Common/Grid/Grid";

    export default {
        components: {TranslationModal, VuePagination, Grid},
        data() {
            return {
                grid: grid(),
                modals: {
                    form: false
                },
                formType: 'create',
                translationsPagination: {
                    total: 0,
                    per_page: 20,
                    from: 1,
                    to: 0,
                    current_page: 1
                },
                offset: 4,
                search: '',
            }
        },
        computed: {
            ...mapGetters('translation', ['translations']),
        },
        mounted() {
            this.getTranslations();
        },
        methods: {
            getTranslations() {
                Vent.$emit('grid-refresh', {search: this.search});
            },
        }
    }
</script>

<style scoped>
    .mt-40 {
        margin-top: 40px;
    }
    .mb-40 {
        margin-bottom: 40px;
    }
</style>
