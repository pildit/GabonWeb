<template>
    <div class="text-right">
        <a v-permission="'companies.edit'" class="text-success aligned fz-16" @click="editCompany(rowProp.Id)" :title="translate('edit')" v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <company-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form"></company-modal>
    </div>
</template>

<script>
import Company from "components/Company/Company";
import CompanyModal from "./CompanyModal";

export default {

    props: ["rowProp", "optionsProp"],

    components: {CompanyModal},

    data() {
        return {
            modals: {
                form: false
            },
        }
    },

    methods: {
        editCompany(id) {
          this.modals.form = true;
        },
    }
}
</script>

<style scoped>

</style>
