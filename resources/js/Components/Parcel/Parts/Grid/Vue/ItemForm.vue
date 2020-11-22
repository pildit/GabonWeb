<template>
  <div>
    <div class="md-form mb-5">
      <input type="text" v-model="form.Name" name="Name" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="name" :class="{'active': form.Name}">{{ translate('abbreviation') }}</label>
      <div v-show="errors.has('Name')" class="invalid-feedback">{{ errors.first('Name') }}</div>
    </div>


  </div>
</template>

<script>
import Item from "components/Parcel/Parcel";


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
          Item.add({
              Name: this.form.Name
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
              Name: this.form.Name
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
