<template>
    <div class="h-100">
        <div class="container text-center pt-5">
            <div class="card mx-auto mb-5" style="width:500px">
                <h5 class="card-header success-color white-text text-center py-4">
                    <strong>{{ translate("forgot_password") }}</strong>
                </h5>
                <!--Card content-->
                <div class="card-body px-lg-5 ">
                    <!-- Form -->
                    <form @submit.prevent="onSubmit" id="login_form" novalidate>
                        <!-- Email -->
                        <div class="md-form">
                            <label for="email">{{ translate("email") }}</label>
                            <input type='email' id="email" name="email"
                                   v-model="recoveryForm.email"
                                   v-validate="'required|email'"
                                   class="form-control notempty" />
                            <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                            <div v-show="success" class="valid-feedback">{{translate('forgot_password_success')}}</div>
                        </div>
                        <button type="submit" class="btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0" >{{translate("recover_password")}}</button>
                    </form>
                    <!-- Form -->
                    <div class="alert alert-danger" v-show="failed">{{ translate(failed) }}</div>
                    <div class="alert alert-success" v-show="success">{{ translate('forgot_password_success') }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import User from "components/User/User";
    // import VueHcaptcha from '@hcaptcha/vue-hcaptcha';

    export default {
        data() {
            return {
                recoveryForm: {
                    email: '',
                    hcaptchaVerified: false,
                    hcaptchaError: false,
                    captchaErrorMessage: ''
                },
                rememberMe: false,
                failed: null,
                success: false,
            }
        },
        // components: { VueHcaptcha },
        methods: {
            markHcaptchaAsVerified(response) {
                this.recoveryForm.captchaErrorMessage = '';
                this.recoveryForm.hcaptchaVerified = true;
                this.recoveryForm.hcaptchaError = false;
            },
            markHcaptchaAsError(response) {
                this.recoveryForm.captchaErrorMessage =  this.translate("captcha_error");
                this.recoveryForm.hcaptchaVerified = false;
                this.recoveryForm.hcaptchaError = true;
            },
            onSubmit() {
                this.$validator.validate().then((valid) => {
                    if(valid) {
                        // if (!this.recoveryForm.hcaptchaVerified) {
                        //     this.recoveryForm.hcaptchaError = true;
                        //     this.recoveryForm.captchaErrorMessage = this.translate("captcha_error");
                        //     return true;
                        // }
                        User.forgot(this.recoveryForm.email)
                            .then((data) => {
                                this.failed = null;
                                this.success = true;
                            })
                            .catch((error) => {
                                console.log(error);
                                if(error) {
                                    // window.hcaptcha.reset();
                                    this.recoveryForm.hcaptchaVerified = false;
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
