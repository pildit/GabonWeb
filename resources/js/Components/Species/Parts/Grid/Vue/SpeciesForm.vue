<template>
  <div>
    <div class="md-form mb-5">
      <input type="text" v-model="form.Code" id="Code" name="Code" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="Code" :class="{'active': form.Code}">{{ translate('code') }}</label>
      <div v-show="errors.has('Code')" class="invalid-feedback">{{ errors.first('Code') }}</div>
    </div>

    <div class="md-form mb-5">
      <input type="text" v-model="form.LatinName" id="LatinName" name="LatinName" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="LatinName" :class="{'active': form.LatinName}">{{ translate('latin_name') }}</label>
      <div v-show="errors.has('LatinName')" class="invalid-feedback">{{ errors.first('LatinName') }}</div>
    </div>

    <div class="md-form mb-5">
      <input type="text" v-model="form.CommonName" id="CommonName" name="CommonName" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="CommonName" :class="{'active': form.CommonName}">{{ translate('common_name') }}</label>
      <div v-show="errors.has('CommonName')" class="invalid-feedback">{{ errors.first('CommonName') }}</div>
    </div>

  </div>
</template>

<script>
import Species from "components/Species/Species";

export default {
  data() {
    return {
      form : {},
    }
  },

  computed: {
  },

  methods: {
    save() {
      this.$validator.validate().then((valid) => {
        if(valid) {
          Species.add({
              code: this.form.Code,
              'latin-name': this.form.LatinName,
              'common-name': this.form.CommonName
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

          Species.update(this.form.Id, {
            code: this.form.Code,
            'latin-name': this.form.LatinName,
            'common-name': this.form.CommonName
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
