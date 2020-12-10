<template>
    <div class="h-100">
        <div class="container text-center pt-5">
            <div class="card mx-auto mb-5" style="width:500px">
                <h5 class="card-header success-color white-text text-center py-4">
                    <strong>{{ translate("reset_password") }}</strong>
                </h5>
                <!--Card content-->
                <div class="card-body px-lg-5 ">
                    <!-- Form -->
                    <form @submit.prevent="onSubmit" id="login_form" novalidate>
                        <!-- Email -->
                        <div class="md-form">
                            <label for="password">{{ translate('password') }}</label>
                            <input type="password"
                                   ref="password"
                                   v-model="resetForm.password"
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
                                   v-model="resetForm.password_confirmation"
                                   v-validate="'required|confirmed:password'"
                                   :data-vv-as="translate('password_confirmation')"
                                   class="form-control"
                                   name="confirm_password"
                                   id="confirm_password"  />
                            <div v-show="errors.has('confirm_password')" class="invalid-feedback">{{ errors.first('confirm_password') }}</div>
                        </div>
                        <button type="submit" class="btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0" >{{translate("reset_password")}}</button>
                    </form>
                    <!-- Form -->
                    <div class="alert alert-danger" v-show="failed">{{ translate(failed) }}</div>
                    <div class="alert alert-success" v-show="success">{{ translate('reset_password_success') }}</div>
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
                resetForm: {
                    code: new URLSearchParams(window.location.search).get('code'),
                    password: '',
                    password_confirmation: '',
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
                this.resetForm.captchaErrorMessage = '';
                this.resetForm.hcaptchaVerified = true;
                this.resetForm.hcaptchaError = false;
            },
            markHcaptchaAsError(response) {
                this.resetForm.captchaErrorMessage =  this.translate("captcha_error");
                this.resetForm.hcaptchaVerified = false;
                this.resetForm.hcaptchaError = true;
            },
            onSubmit() {
                this.$validator.validate().then((valid) => {
                    if(valid) {
                        // if (!this.resetForm.hcaptchaVerified) {
                        //     this.resetForm.hcaptchaError = true;
                        //     this.resetForm.captchaErrorMessage = this.translate("captcha_error");
                        //     return true;
                        // }
                        User.reset(this.resetForm)
                            .then((data) => {
                                this.failed = null;
                                this.success = true;
                                setTimeout( () => {
                                    window.location.replace('/login');
                                }, 1000)
                            })
                            .catch((error) => {
                                console.log(error);
                                if(error) {
                                    window.hcaptcha.reset();
                                    this.resetForm.hcaptchaVerified = false;
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
