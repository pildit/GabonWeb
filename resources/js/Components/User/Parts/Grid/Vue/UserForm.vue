<template>
    <div>
        <div class="md-form mb-5 ">
            <label for="firstname">{{translate('Firstname')}}</label>
            <input type="text"
                   v-model="form.firstname"
                   v-validate="'required'"
                   :data-vv-as="translate('firstname')"
                   class="form-control notempty"
                   name="firstname"
                   id="firstname"/>
            <div v-show="errors.has('firstname')" class="invalid-feedback">{{ errors.first('firstname') }}</div>
        </div>
        <div class="md-form mb-5 ">
            <label for="lastname">{{translate('Lastname')}}</label>
            <input type="text"
                   v-model="form.lastname"
                   v-validate="'required'"
                   :data-vv-as="translate('lastname')"
                   class="form-control notempty"
                   name="lastname"
                   id="lastname"/>
            <div v-show="errors.has('lastname')" class="invalid-feedback">{{ errors.first('lastname') }}</div>
        </div>
        <div class="md-form mb-5">
            <label for="email">{{translate('Email')}}</label>
            <input type="email"
                   v-model="form.email"
                   v-validate="'required|email'"
                   :data-vv-as="translate('email')"
                   class="form-control notempty"
                   name="email"
                   id="email"/>
            <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
        </div>
        <div class="md-form mb-5">
            <label for="password">{{translate('Password')}}</label>
            <input type="password"
                   ref="password"
                   v-model="form.password"
                   v-validate="'required'"
                   :data-vv-as="translate('password')"
                   class="form-control"
                   name="password"
                   id="password"  />
            <div v-show="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>
        </div>

        <div class="md-form mb-5">
            <label for="confirm_password">{{translate('Confirm password')}}</label>
            <input type="password"
                   v-model="form.password_confirmation"
                   v-validate="'required|confirmed:password'"
                   :data-vv-as="translate('password_confirmation')"
                   class="form-control"
                   name="confirm_password"
                   id="confirm_password"  />
            <div v-show="errors.has('confirm_password')" class="invalid-feedback">{{ errors.first('confirm_password') }}</div>
        </div>
    </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import User from "components/User/User";

export default {
    mixins: [Translation],

    data() {
        return {
            form: {}
        }
    },

    methods: {
        save() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    User.add(this.form).then(() => {
                        this.$emit('done');
                    }).catch((error) => {
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
