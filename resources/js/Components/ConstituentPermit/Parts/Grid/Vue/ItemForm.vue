<template>
  <div>

    <div class="md-form mb-5">
      <multiselect
          v-model="form.PermitTypeObj"
          :options="types"
          placeholder="Types"
          track-by="Id"
          label="Permit Type"
          :allow-empty="false"
          :multiple="false"
          :taggable="true"
      ></multiselect>
    </div>

    <div class="md-form mb-5">
      <input type="text" v-model="form.PermitNumber" name="PermitNumber" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="PermitNumber" :class="{'active': form.PermitNumber}">{{ translate('Permit Number') }}</label>
      <div v-show="errors.has('PermitNumber')" class="invalid-feedback">{{ errors.first('PermitNumber') }}</div>
    </div>


  </div>
</template>

<script>
import Item from "../../../ConstituentPermit";
import Multiselect from "vue-multiselect";
import {mapGetters} from 'vuex';


export default {
  data() {
    return {
      form : {},
    }
  },
  components : {Multiselect},
  computed: {
    ...mapGetters('constituentPermit', ['types'])
  },
  created() {
    this.$store.dispatch('constituentPermit/types');
  },
  methods: {

    save() {
      this.$validator.validate().then((valid) => {
        if(valid) {
          Item.add({
            permit_type :this.form.PermitType,
            permit_number: this.form.PermitNumber
          }).then((response) => {
            this.$emit('done');
          }).catch((error) => {
            if(error) {
              this.$setErrorsFromResponse(error.data);
            }
          })
        }
      });
    },
    update() {
      this.$validator.validate().then((valid) => {
        if(valid) {
          Item.update(this.form.Id, {
            permit_type :this.form.PermitType,
            permit_number: this.form.PermitNumber
          }).then(() => {
            this.$emit('done');
          }).catch((error) => {
            if(error) {
              this.$setErrorsFromResponse(error.data);
            }
          })
        }
      })
    }
  },
}
</script>

<style scoped>

</style>
