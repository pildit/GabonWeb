<template>
    <div>
        <div class="md-form mb-5">
            <input type="text" v-model="form.text_key" id="text_key" name="text_key" class="form-control" v-validate="'required'">
            <label data-error="wrong" data-success="right" for="text_key" :class="{'active': form.text_key}">{{ translate('text_key') }}</label>
            <div v-show="errors.has('text_key')" class="invalid-feedback">{{ errors.first('text_key') }}</div>
        </div>

        <div class="md-form mb-5">
            <input type="text" v-model="form.text_us" id="text_us" name="text_us" class="form-control" v-validate="'required'">
            <label data-error="wrong" data-success="right" for="text_us" :class="{'active': form.text_us}">{{ translate('text_us') }}</label>
            <div v-show="errors.has('text_us')" class="invalid-feedback">{{ errors.first('text_us') }}</div>
        </div>

        <div class="md-form mb-5">
            <input type="text" v-model="form.text_ga" id="text_ga" name="text_ga" class="form-control" v-validate="'required'">
            <label data-error="wrong" data-success="right" for="text_ga" :class="{'active': form.text_ga}">{{ translate('text_ga') }}</label>
            <div v-show="errors.has('text_ga')" class="invalid-feedback">{{ errors.first('text_ga') }}</div>
        </div>

        <div class="form-group text-left mb-5">
            <switches v-model="form.mobile" color="green" :title="translate('mobile')" v-tooltip></switches>
            {{ translate('mobile') }}
        </div>

    </div>
</template>

<script>

    import Translation from "components/Translations/Translation";
    import Switches from 'vue-switches';
    import {mapGetters} from "vuex";

    export default {

        data() {
            return {
                form : {}
            }
        },
        computed: {
            ...mapGetters('translation', ['translation'])
        },
        components: {Switches},
        methods: {
            save() {
                this.$validator.validate().then((valid) => {
                    if(valid) {
                        var f = this.form
                        Translation.add({
                            text_key: f.text_key,
                            text_us: f.text_us,
                            text_ga: f.text_ga,
                            mobile: f.mobile ? 1 : 0
                        }).then( response => {
                            this.$emit('done');
                        }).catch( error => {
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
                        var f = this.form
                        Translation.update(f.id, {
                            text_key: f.text_key,
                            text_us: f.text_us,
                            text_ga: f.text_ga,
                            mobile: f.mobile ? 1 : 0
                        }).then( () => {
                            this.$emit('done');
                        }).catch( error => {
                            if(error) {
                                this.$setErrorsFromResponse(error.data);
                            }
                        })
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
