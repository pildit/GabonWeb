<template>
  <bmodal ref="speciesModal" size="medium" :closed="() => $emit('display', false)">
    <div slot="title">
      <h4 class="modal-title w-100 font-weight-bold">{{ translate('add_species') }}</h4>
    </div>
    <div slot="body">
      <species-form ref="SpeciesForm" @done="closeModal"></species-form>
    </div>
    <div slot="footer">
      <button @click="submit" class="btn btn-default">{{ translate('save') }}</button>
      <button @click="closeModal" class="btn btn-warning">{{ translate('cancel') }}</button>
    </div>
  </bmodal>
</template>

<script>

import bmodal from 'components/Common/BootstrapModal.vue';
import SpeciesForm from "./SpeciesForm";
import {mapGetters} from 'vuex';

export default {
  model: {
    prop: 'state',
    event: 'display'
  },

  props: ['state', 'typeProp', 'rowProp'],

  components: {bmodal, SpeciesForm},

  computed: {
    ...mapGetters('species', ['species'])
  },

  methods: {
    submit() {
      if(this.typeProp == 'create') {
        this.$refs.SpeciesForm.save();
      }else{
        this.$refs.SpeciesForm.update();
      }
    },
    closeModal() {
      this.$refs.speciesModal.close();
      this.$emit('done');
      Vent.$emit('grid-refresh');
    }
  },

  watch: {
    state(val) {
      if(!val) return;
      if(this.typeProp != 'create') {
        this.$refs.SpeciesForm.form = this.rowProp;
      }else{
        this.$refs.SpeciesForm.form = {};
      }
      this.$refs.SpeciesForm.errors.clear();
      this.$refs.speciesModal.open();
    }
  }
}
</script>

<style scoped>
</style>
