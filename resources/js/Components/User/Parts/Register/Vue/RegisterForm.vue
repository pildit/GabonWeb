<template>
    <main class="page login-page">
        <div class="container text-center pt-5">
            <div class="card mx-auto mb-5" style="width:500px">
                <h5 class="card-header success-color white-text text-center py-4">
                    <strong>{{ translate('sign_up') }}</strong>
                </h5>
                <div class="card-body px-lg-5 ">
                    <form @submit.prevent="onSubmit" id='sign_up_form' novalidate>
                        <div class="md-form ">
                            <label for="firstname">{{ translate('first_name') }}</label>
                            <input type="text"
                                   v-model="registerForm.firstname"
                                   v-validate="'required'"
                                   :data-vv-as="translate('first_name')"
                                   class="form-control notempty"
                                   name="firstname"
                                   id="firstname"/>
                            <div v-show="errors.has('firstname')" class="invalid-feedback">{{ errors.first('firstname') }}</div>
                        </div>
                        <div class="md-form ">
                            <label for="lastname">{{ translate('last_name') }}</label>
                            <input type="text"
                                   v-model="registerForm.lastname"
                                   v-validate="'required'"
                                   :data-vv-as="translate('last_name')"
                                   class="form-control notempty"
                                   name="lastname"
                                   id="lastname"/>
                            <div v-show="errors.has('lastname')" class="invalid-feedback">{{ errors.first('lastname') }}</div>
                        </div>
                        <div class="md-form">
                            <label for="email">{{ translate('email') }}</label>
                            <input type="email"
                                   v-model="registerForm.email"
                                   v-validate="'required|email'"
                                   :data-vv-as="translate('email')"
                                   class="form-control notempty"
                                   name="email"
                                   id="email"/>
                            <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                        </div>
                        <div class="md-form">
                            <label for="password">{{ translate('password') }}</label>
                            <input type="password"
                                   ref="password"
                                   v-model="registerForm.password"
                                   v-validate="'required'"
                                   :data-vv-as="translate('password')"
                                   class="form-control"
                                   name="password"
                                   id="password"  />
                            <div v-show="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>
                        </div>

                        <div class="md-form">
                            <label for="confirm_password">{{ translate('confirm_password') }}</label>
                            <input type="password"
                                   v-model="registerForm.password_confirmation"
                                   v-validate="'required|confirmed:password'"
                                   :data-vv-as="translate('password_confirmation')"
                                   class="form-control"
                                   name="confirm_password"
                                   id="confirm_password"  />
                            <div v-show="errors.has('confirm_password')" class="invalid-feedback">{{ errors.first('confirm_password') }}</div>
                        </div>
                        <div class="md-form ">
<!--                            <vue-hcaptcha sitekey="541e440b-1499-42db-a88f-28e5f066bca9" @verify="markHcaptchaAsVerified" @error="markHcaptchaAsError"></vue-hcaptcha>-->
                            <div class="invalid-feedback" v-show="registerForm.hcaptchaError">{{ registerForm.captchaErrorMessage }}</div>
                        </div>
                        <button type='submit' class='btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0'>{{translate('sign_up')}}</button>
                    </form>
                    <div class="alert alert-danger" v-show="failed">{{ translate(failed) }}</div>
                    <div class="alert alert-success" v-show="success">{{ translate(success) }}</div>

                </div>
            </div>
        </div>
    </main>
</template>

<script>

import User from "components/User/User";
import VueHcaptcha from '@hcaptcha/vue-hcaptcha'

export default {
    data() {
        return {
            registerForm: {
                hcaptchaVerified: false,
                hcaptchaError: false,
                captchaErrorMessage: ''
            },
            failed: null,
            success: null
        }
    },
    // components: { VueHcaptcha },
    methods: {
        markHcaptchaAsVerified(response) {
            this.registerForm.captchaErrorMessage = '';
            this.registerForm.hcaptchaVerified = true;
            this.registerForm.hcaptchaError = false;
        },
        markHcaptchaAsError(response) {
            this.registerForm.captchaErrorMessage =  this.translate("captcha_error");
            this.registerForm.hcaptchaVerified = false;
            this.registerForm.hcaptchaError = true;
        },
        onSubmit() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    // if (!this.registerForm.hcaptchaVerified) {
                    //     this.registerForm.hcaptchaError = true;
                    //     this.registerForm.captchaErrorMessage = this.translate("captcha_error");
                    //     return true;
                    // }
                    this.failed = null;
                    this.success = null;
                    User.register(this.registerForm)
                        .then((data) => {
                            this.success = data.message;
                            setTimeout(() => {
                                window.location.href='/';
                            },2000);
                        })
                        .catch((error) => {
                            if(error) {
                                // window.hcaptcha.reset();
                                this.registerForm.hcaptchaVerified = false;
                                if ([401, 404].includes(error.status)) {
                                    this.failed = error.data.message;
                                }
                                this.$setErrorsFromResponse(error.data);
                            }
                        });
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
