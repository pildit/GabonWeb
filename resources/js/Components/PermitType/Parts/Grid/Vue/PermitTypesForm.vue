<template>
  <div>
    <div class="md-form mb-5">
      <input type="text" v-model="form.Abbreviation" name="Abbreviation" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="Abbreviation" :class="{'active': form.Abbreviation}">{{ translate('Abbreviation') }}</label>
      <div v-show="errors.has('Abbreviation')" class="invalid-feedback">{{ errors.first('Abbreviation') }}</div>
    </div>

    <div class="md-form mb-5">
      <input type="text" v-model="form.Name" name="Name" class="form-control" >
      <label data-error="wrong" data-success="right" for="name" :class="{'active': form.Name}">{{ translate('Name') }}</label>
      <div v-show="errors.has('Name')" class="invalid-feedback">{{ errors.first('Name') }}</div>
    </div>


  </div>
</template>

<script>
import PermitType from "../../../PermitType";


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
          PermitType.add({
              abbreviation: this.form.Abbreviation,
              name: this.form.Name
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

          PermitType.update(this.form.id, {
              abbreviation: this.form.Abbreviation,
              name: this.form.Name
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
