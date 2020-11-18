<template>
  <div>
    <div class="md-form mb-5">
      <input type="text" v-model="form.Value" name="Value" class="form-control" v-validate="'required|integer'">
      <label data-error="wrong" data-success="right" for="Value" :class="{'active': form.Value}">{{ translate('Value') }}</label>
      <div v-show="errors.has('Value')" class="invalid-feedback">{{ errors.first('Value') }}</div>
    </div>

    <div class="md-form mb-5">
      <input type="text" v-model="form.Description" name="Description" class="form-control">
      <label data-error="wrong" data-success="right" for="Description" :class="{'active': form.Description}">{{ translate('Description') }}</label>
      <div v-show="errors.has('Description')" class="invalid-feedback">{{ errors.first('Description') }}</div>
    </div>


  </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import Quality from "components/Quality/Quality";


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
          Quality.add({
            value: parseInt(this.form.Value),
            description: this.form.Description
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

          Quality.update(this.form.Id, {
            value: parseInt(this.form.Value),
            description: this.form.Description
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
