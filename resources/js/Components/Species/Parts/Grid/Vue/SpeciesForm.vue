<template>
  <div>
    <div class="md-form mb-5">
      <input type="text" v-model="form.Code" name="Code" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="Code" :class="{'active': form.Code}">{{ translate('Code') }}</label>
      <div v-show="errors.has('Code')" class="invalid-feedback">{{ errors.first('Code') }}</div>
    </div>

    <div class="md-form mb-5">
      <input type="text" v-model="form.LatinName" name="LatinName" class="form-control" >
      <label data-error="wrong" data-success="right" for="name" :class="{'active': form.LatinName}">{{ translate('LatinName') }}</label>
      <div v-show="errors.has('LatinName')" class="invalid-feedback">{{ errors.first('LatinName') }}</div>
    </div>

    <div class="md-form mb-5">
      <input type="text" v-model="form.CommonName" name="CommonName" class="form-control" >
      <label data-error="wrong" data-success="right" for="name" :class="{'active': form.CommonName}">{{ translate('CommonName') }}</label>
      <div v-show="errors.has('CommonName')" class="invalid-feedback">{{ errors.first('CommonName') }}</div>
    </div>

  </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import Species from "components/Species/Species";


export default {
  mixins: [Translation],
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
