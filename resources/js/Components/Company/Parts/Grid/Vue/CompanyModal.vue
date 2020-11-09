<template>
    <bmodal ref="companyModal" size="medium" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold">{{translate('add_company')}}</h4>
        </div>
        <div slot="body">
            <company-form :type-prop="typeProp" ref="companyForm" @done="closeModal"></company-form>
        </div>
        <div slot="footer">
            <button @click="submit" class="btn btn-default">Save</button>
            <button @click="closeModal"class="btn btn-warning">Cancel</button>
        </div>
    </bmodal>
</template>

<script>
import Translation from "components/Mixins/Translation";
import bmodal from 'components/Common/BootstrapModal.vue';
import CompanyForm from "./CompanyForm";
import {mapGetters} from 'vuex';

export default {
    model: {
      prop: 'state',
      event: 'display'
    },

    mixins: [Translation],

    props: ['state', 'typeProp'],

    components: {bmodal, CompanyForm},

    computed: {
       ...mapGetters('company', ['company', 'types'])
    },

    methods: {
        submit() {
            if(this.typeProp == 'create') {
                this.$refs.companyForm.save();
            }else{
                this.$refs.companyForm.update();
            }
        },
        closeModal() {
            this.$refs.companyModal.close();
            this.$emit('done');
        }
    },

    watch: {
        state(val) {
            if(!val) return;
            if(this.typeProp != 'create') {
                this.$refs.companyForm.form = this.company;
            }else{
                this.$refs.companyForm.form = {};
            }
            this.$refs.companyForm.errors.clear();
            this.$refs.companyModal.open();
        }
    }
}
</script>

<style scoped>

</style>
