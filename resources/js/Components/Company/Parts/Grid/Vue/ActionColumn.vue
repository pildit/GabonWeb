<template>
    <div class="text-right">
        <span class="btn btn-sm btn-outline-success" @click="editCompany(rowProp.Id)">
            <i class="fas fa-edit"></i>
            {{translate('Edit')}}
        </span>
        <company-modal type-prop="edit" v-model="modals.form"></company-modal>
    </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import Company from "components/Company/Company";
import CompanyModal from "./CompanyModal";

export default {
    mixins: [Translation],

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
            Company.get(id).then(() => this.modals.form = true);
        },
    }
}
</script>

<style scoped>

</style>
