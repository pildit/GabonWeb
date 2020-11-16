<template>
  <bmodal ref="itemModal" size="medium" :closed="() => $emit('display', false)">
    <div slot="title">
      <h4 class="modal-title w-100 font-weight-bold">{{translate('add_permit_type')}}</h4>
    </div>
    <div slot="body">
      <item-form ref="itemForm" @done="closeModal"></item-form>
    </div>
    <div slot="footer">
      <button @click="submit" class="btn btn-default">Save</button>
      <button @click="closeModal" class="btn btn-warning">Cancel</button>
    </div>
  </bmodal>
</template>

<script>
import bmodal from 'components/Common/BootstrapModal.vue';
import itemForm from "./ItemForm.vue";
import {mapGetters} from 'vuex';

export default {
  model: {
      prop: 'state',
    event: 'display'
  },

  props: ['state', 'typeProp', 'rowProp'],

  components: {bmodal, itemForm},

  computed: {
    ...mapGetters('permitTypes', ['permitTypes'])
  },

  methods: {
    submit() {
      if(this.typeProp == 'create') {
        this.$refs.itemForm.save();
      }else{
        this.$refs.itemForm.update();
      }
    },
    closeModal() {
      this.$refs.itemModal.close();
      this.$emit('done');
      Vent.$emit('grid-refresh');
    }
  },

  watch: {
    state(val) {
      if(!val) return;
      if(this.typeProp != 'create') {
        this.$refs.itemForm.form = this.rowProp;
      }else{
        this.$refs.itemForm.form = {};
      }
      this.$refs.itemForm.errors.clear();
      this.$refs.itemModal.open();
    }
  }
}
</script>

<style scoped>
</style>
