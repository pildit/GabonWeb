<template>
    <bmodal ref="qualityModal" size="medium" :closed="() => $emit('display', false)">
      <div slot="title">
        <h4 class="modal-title w-100 font-weight-bold">{{translate('add_quality')}}</h4>
      </div>
      <div slot="body">
        <quality-form ref="qualityForm" @done="closeModal"></quality-form>
      </div>
      <div slot="footer">
        <button @click="submit" class="btn btn-default">{{ translate('save') }}</button>
        <button @click="closeModal" class="btn btn-warning">{{ translate('cancel') }}</button>
      </div>
    </bmodal>
</template>

<script>
import Translation from "components/Mixins/Translation";
import bmodal from 'components/Common/BootstrapModal.vue';
import qualityForm from "./QualityForm";
import {mapGetters} from 'vuex';

export default {
  model: {
    prop: 'state',
    event: 'display'
  },
  mixins: [Translation],

  props: ['state', 'typeProp', 'qualityProp'],

  components: {bmodal, qualityForm},

  computed: {
    ...mapGetters('quality', ['quality'])
  },

  methods: {
    submit() {
      if(this.typeProp == 'create') {
        this.$refs.qualityForm.save();
      }else{
        this.$refs.qualityForm.update();
      }
    },
    closeModal() {
      this.$refs.qualityModal.close();
      this.$emit('done');
      Vent.$emit('grid-refresh');
    }
  },

  watch: {
    state(val) {
      if(!val) return;
      if(this.typeProp != 'create') {
        this.$refs.qualityForm.form = this.qualityProp;
      }else{
        this.$refs.qualityForm.form = {};
      }
      this.$refs.qualityForm.errors.clear();
      this.$refs.qualityModal.open();
    }
  }
}
</script>

<style scoped>
</style>
