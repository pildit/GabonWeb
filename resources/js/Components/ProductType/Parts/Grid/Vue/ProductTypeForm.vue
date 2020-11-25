<template>
  <div>
    <div class="md-form mb-5">
      <input type="text" v-model="form.Name" name="Name" id="Name" class="form-control" v-validate="'required'">
      <label data-error="wrong" data-success="right" for="Name" :class="{'active': form.Name}">{{ translate('name') }}</label>
      <div v-show="errors.has('Name')" class="invalid-feedback">{{ errors.first('Name') }}</div>
    </div>
  </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import ProductType from "../../../ProductType";


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
          ProductType.add({
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
          ProductType.update(this.form.Id, {
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
