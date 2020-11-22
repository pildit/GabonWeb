<template>
  <bmodal ref="permitTypesModal" size="medium" :closed="() => $emit('display', false)">
    <div slot="title">
      <h4 class="modal-title w-100 font-weight-bold">{{ translate('add_permit_type') }}</h4>
    </div>
    <div slot="body">
      <permit-types-form ref="PermitTypesForm" @done="closeModal"></permit-types-form>
    </div>
    <div slot="footer">
      <button @click="submit" class="btn btn-default">{{ translate('save') }}</button>
      <button @click="closeModal" class="btn btn-warning">{{ translate('cancel') }}</button>
    </div>
  </bmodal>
</template>

<script>
import bmodal from 'components/Common/BootstrapModal.vue';
import PermitTypesForm from "./PermitTypesForm";
import {mapGetters} from 'vuex';

export default {
  model: {
      prop: 'state',
    event: 'display'
  },

  props: ['state', 'typeProp', 'rowProp'],

  components: {bmodal, PermitTypesForm},

  computed: {
    ...mapGetters('permitTypes', ['permitTypes'])
  },

  methods: {
    submit() {
      if(this.typeProp == 'create') {
        this.$refs.PermitTypesForm.save();
      }else{
        this.$refs.PermitTypesForm.update();
      }
    },
    closeModal() {
      this.$refs.permitTypesModal.close();
      this.$emit('done');
      Vent.$emit('grid-refresh');
    }
  },

  watch: {
    state(val) {
      if(!val) return;
      if(this.typeProp != 'create') {
        this.$refs.PermitTypesForm.form = this.rowProp;
      }else{
        this.$refs.PermitTypesForm.form = {};
      }
      this.$refs.PermitTypesForm.errors.clear();
      this.$refs.permitTypesModal.open();
    }
  }
}
</script>

<style scoped>
</style>
