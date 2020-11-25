<template>
    <div class="h-100">
        <div class="container text-center pt-5">
            <div class="card mx-auto mb-5" style="width:500px">
                <h5 class="card-header success-color white-text text-center py-4">
                    <strong>{{ translate("sign_in") }}</strong>
                </h5>
                <!--Card content-->
                <div class="card-body px-lg-5 ">
                    <!-- Form -->
                    <form @submit.prevent="onSubmit" id="login_form" novalidate>
                        <!-- Email -->
                        <div class="md-form">
                            <label for="email">{{ translate("email") }}</label>
                            <input type='email' id="email" name="email"
                                   v-model="loginForm.email"
                                   v-validate="'required|email'"
                                   class="form-control notempty" />
                            <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                        </div>
                        <!-- Password -->
                        <div class="md-form ">
                            <label for="password">{{ translate("password") }}</label>
                            <input type="password" id="password" name="password"
                                   v-model="loginForm.password"
                                   v-validate="'required'"
                                   class="form-control notempty" />
                            <div v-show="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div>
                                <!-- Remember me -->
                                <div class="form-check">
                                    <input type="checkbox" v-model="rememberMe" class="form-check-input" id="rememberMe" name="rememberMe" value=''/>
                                    <label class="form-check-label" for="rememberMe">{{ translate("remember_me")}}</label>
                                </div>
                            </div>
                            <div>
                                <!-- Forgot password -->
                                <a href="/forgot_password" class="text-success">{{ translate("forgot_password") }}?</a>
                            </div>
                        </div>
                        <div class="md-form ">
                            <vue-hcaptcha sitekey="541e440b-1499-42db-a88f-28e5f066bca9" @verify="markHcaptchaAsVerified" @error="markHcaptchaAsError"></vue-hcaptcha>
                            <div class="invalid-feedback" v-show="loginForm.hcaptchaError">{{ loginForm.captchaErrorMessage }}</div>
                        </div>
                        <!-- Sign in button -->
                        <button type="submit" class="btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0" >{{translate("sign_in")}}</button>
                        <!-- Register -->
                        <p>{{ translate("not_a_member") }}?
                            <a href="/register" class="text-success">{{ translate("register") }}</a>
                        </p>
                    </form>
                    <!-- Form -->
                    <div class="alert alert-danger" v-show="failed">{{ translate(failed) }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import User from "components/User/User";
import VueHcaptcha from '@hcaptcha/vue-hcaptcha';

export default {
    data() {
        return {
            loginForm: {
                hcaptchaVerified: false,
                hcaptchaError: false,
                captchaErrorMessage: ''
            },
            rememberMe: false,
            failed: null,
        }
    },
    components: { VueHcaptcha },
    methods: {
        markHcaptchaAsVerified(response) {
            this.loginForm.captchaErrorMessage = '';
            this.loginForm.hcaptchaVerified = true;
            this.loginForm.hcaptchaError = false;
        },
        markHcaptchaAsError(response) {
            this.loginForm.captchaErrorMessage =  this.translate("captcha_error");
            this.loginForm.hcaptchaVerified = false;
            this.loginForm.hcaptchaError = true;
        },
        onSubmit() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    if (!this.loginForm.hcaptchaVerified) {
                        this.loginForm.hcaptchaError = true;
                        this.loginForm.captchaErrorMessage = this.translate("captcha_error");
                        return true;
                    }
                    User.login(this.loginForm.email, this.loginForm.password)
                        .then((data) => {
                            this.failed = null;
                            this.$setCookie('jwt', data['jwt'], {expires: this.rememberMe ? 365 : 1});
                            window.location.href = '/';
                        })
                        .catch((error) => {
                            console.log(error);
                            if(error) {
                                window.hcaptcha.reset();
                                this.loginForm.hcaptchaVerified = false;
                                if([401,404].includes(error.status)) {
                                    this.failed = error.data.message;
                                }
                                this.$setErrorsFromResponse(error.data);
                            }
                        });
                }
            });
        }
    }

}
</script>

<style scoped>

</style>
