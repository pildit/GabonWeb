<template>
    <div class="text-right">
        <a v-permission="'companies.edit'" class="text-success aligned fz-16" @click="editCompany(rowProp.Id)" :title="translate('edit')" v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <a class="text-danger fz-16" @click.prevent="deleteCompany" v-permission="'companies.delete'">
            <i class="fas fa-trash"></i>
        </a>
        <company-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form"></company-modal>
    </div>
</template>

<script>
import Company from "components/Company/Company";
import CompanyModal from "./CompanyModal";
import Confirmation from "../../../../Common/Confirmation/Confirmation";

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
        deleteCompany () {
            return Confirmation(this.translate('corfirmation_delete_question')).then((result) => {
                if(result.isConfirmed) {
                    Company.delete(this.rowProp.Id).finally(() => {
                        Vent.$emit('grid-refresh')
                    });
                }
            })

        },
        editCompany(id) {
          this.modals.form = true;
        },
    }
}
</script>

<style scoped>

</style>
