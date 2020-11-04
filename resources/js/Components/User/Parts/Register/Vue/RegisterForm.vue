<template>
    <main class="page login-page">
        <div class="container text-center pt-5">
            <div class="card mx-auto mb-5" style="width:500px">
                <h5 class="card-header success-color white-text text-center py-4">
                    <strong>{{translate('Sign up')}}</strong>
                </h5>
                <div class="card-body px-lg-5 ">
                    <form @submit.prevent="onSubmit" id='sign_up_form' novalidate>
                        <div class="md-form ">
                            <label for="firstname">{{translate('Firstname')}}</label>
                            <input type="text"
                                   v-model="registerForm.firstname"
                                   v-validate="'required'"
                                   :data-vv-as="translate('firstname')"
                                   class="form-control notempty"
                                   name="firstname"
                                   id="firstname"/>
                            <div v-show="errors.has('firstname')" class="invalid-feedback">{{ errors.first('firstname') }}</div>
                        </div>
                        <div class="md-form ">
                            <label for="lastname">{{translate('Lastname')}}</label>
                            <input type="text"
                                   v-model="registerForm.lastname"
                                   v-validate="'required'"
                                   :data-vv-as="translate('lastname')"
                                   class="form-control notempty"
                                   name="lastname"
                                   id="lastname"/>
                            <div v-show="errors.has('lastname')" class="invalid-feedback">{{ errors.first('lastname') }}</div>
                        </div>
                        <div class="md-form">
                            <label for="email">{{translate('Email')}}</label>
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
                            <label for="password">{{translate('Password')}}</label>
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
                            <label for="confirm_password">{{translate('Confirm password')}}</label>
                            <input type="password"
                                   v-model="registerForm.password_confirmation"
                                   v-validate="'required|confirmed:password'"
                                   :data-vv-as="translate('password_confirmation')"
                                   class="form-control"
                                   name="confirm_password"
                                   id="confirm_password"  />
                            <div v-show="errors.has('confirm_password')" class="invalid-feedback">{{ errors.first('confirm_password') }}</div>
                        </div>
                        <button type='submit' class='btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0'>{{translate('Sign Up')}}</button>
                    </form>
                    <div class="alert alert-danger" v-show="failed">{{translate(failed)}}</div>
                    <div class="alert alert-success" v-show="success">{{translate(success)}}</div>

                </div>
            </div>
        </div>
    </main>
</template>

<script>
import Translation from "components/Mixins/Translation";
import User from "components/User/User";

export default {
    data() {
        return {
            registerForm: {},
            failed: null,
            success: null
        }
    },
    mixins: [Translation],
    methods: {
        onSubmit() {
            this.$validator.validate().then((valid) => {
                if(valid) {
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
                            if ([401, 404].includes(error.status)) {
                                this.failed = error.data.message;
                            }
                            this.$setErrorsFromResponse(error.data);
                        });
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
