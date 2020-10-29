<template>
    <div class="h-100">
        <div class="container text-center pt-5">
            <div class="card mx-auto mb-5" style="width:500px">
                <h5 class="card-header success-color white-text text-center py-4">
                    <strong>{{translate("sign_in")}}</strong>
                </h5>
                <!--Card content-->
                <div class="card-body px-lg-5 ">
                    <!-- Form -->
                    <form  id="login_form" novalidate>
                        <!-- Email -->
                        <div class="md-form">
                            <input type="email" id="email" name="email" class="form-control notempty" />
                            <label for="email">{{translate("email")}}</label>
                        </div>
                        <!-- Password -->
                        <div class="md-form ">
                            <input type="password" id="password" name="password" class="form-control notempty" />
                            <label for="password">{{translate("Password")}}</label>
                        </div>
                        <div class="d-flex justify-content-around">
                            <div>
                                <!-- Remember me -->
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe" value=''/>
                                    <label class="form-check-label" for="rememberMe">{{translate("Remember me")}}</label>
                                </div>
                            </div>
                            <div>
                                <!-- Forgot password -->
                                <a href="/forgot_password" class="text-success">{{translate("Forgot password?")}}</a>
                            </div>
                        </div>
                        <!-- Sign in button -->
                        <button type="submit" class="btn btn-outline-success btn-rounded btn-block my-4 waves-effect z-depth-0" >{{translate("Sign in")}}</button>
                        <!-- Register -->
                        <p>{{translate("Not a member?")}}
                            <a href="/register" class="text-success">{{translate("Register")}}</a>
                        </p>
                    </form>
                    <!-- Form -->
                    <div id="response" style="color: rgb(149,28,8); display:block"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Translation from "components/Mixins/Translation";

export default {
    mixins: [Translation],
    methods: {
        login() {
        }
    }
}
</script>

<style scoped>

</style>
