<template>
  <div>
    <div class="md-form mb-5">
      <input type="text" v-model="form.Name" name="Name" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="name" :class="{'active': form.Name}">{{ translate('abbreviation') }}</label>
      <div v-show="errors.has('Name')" class="invalid-feedback">{{ errors.first('Name') }}</div>
    </div>
      <div class="md-form">
          <input type="text" name="Geometry" id="Geometry" class="form-control" v-model="form.Geometry" v-validate="'required'">
          <label for="Geometry" :class="{'active': form.Geometry}">{{translate('geometry_input_label')}}</label>
          <div v-show="errors.has('Geometry')" class="invalid-feedback">{{ errors.first('Geometry') }}</div>
      </div>
  </div>
</template>

<script>
import Item from "components/Parcel/Parcel";


export default {

  props: ['rowProp'],

  data() {
    return {
      form : {},
    }
  },

  created() {
      if(this.rowProp) {
          this.form.Id = this.rowProp.Id;
          this.form.Name = this.rowProp.Name;
          this.form.Geometry = this.rowProp.geometry_as_text;
      }
  },

    methods: {
    save() {
      this.$validator.validate().then((valid) => {
        if(valid) {
          Item.add({
              Name: this.form.Name,
              Geometry: this.form.Geometry
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
              Name: this.form.Name,
              Geometry: this.form.Geometry
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
