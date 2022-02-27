<template>
    <b-form @submit.prevent="register()" class="col-md-12">
        <div class="app-form shadow-lg">
            <div class="row">
                <div class="col-md-8 p-0">
                    <div class="at-left position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white"></div>
                </div>

                <div class="col-md-4 p-0 d-flex justify-content-center align-items-center">
                    <div class="at-right">
                        <h2 class="mb-4">Register</h2>
                        <b-container class="p-0 my-3">
                            <b-row>
                                <label class="mb-2 app-form-label">Your name</label>
                            </b-row>
                            <b-row>
                                <b-col cols="6">
                                    <b-form-group>
                                        <b-form-input v-model="form.first_name" id="first_name" type="text" placeholder="First name" required></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col cols="6">
                                    <b-form-group>
                                        <b-form-input v-model="form.last_name" id="last_name" type="text" placeholder="Last name" required></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-container>
                        <label class="mb-2 app-form-label">Birthdate</label>
                        <b-form-group class="mb-3">
                            <b-form-input id="birthdate" v-model="form.birthdate" type="date" placeholder="Password" required></b-form-input>
                        </b-form-group>
                        <label class="mb-2 app-form-label">Email address</label>
                        <b-form-group class="mb-3">
                            <b-form-input v-model="form.email" id="email" type="email" placeholder="Email address" required></b-form-input>
                        </b-form-group>
                        <label class="mb-2 app-form-label">Password</label>
                        <b-form-group class="mb-3">
                            <b-form-input v-model="form.password" id="password" type="password" placeholder="Password" required></b-form-input>
                        </b-form-group>
                        <label class="mb-2 app-form-label">Confirm password</label>
                        <b-form-group class="mb-3">
                            <b-form-input v-model="form.password_confirmation" id="password-confirm" type="password" placeholder="Confirm password" required></b-form-input>
                        </b-form-group>

                        <button class="btn btn-success app-form-btn shadow border-0 py-2 my-3 text-uppercase">
                            Create Account
                        </button>

                        <p class="text-center">
                            Already own an account?
                            <router-link role="button" class="form-redirect-link" to="/login">Sign in now!</router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </b-form>
</template>

<script>
export default {
    data() {
        return {
            form: {
                first_name: null,
                last_name: null,
                email: null,
                birthdate: null,
                password: null,
                password_confirmation: null,
            }
        }
    },
    watch: {
        'form.birthdate': function (newVal, oldVal) {
            console.log(newVal);
        }
    },
    watch: {
        'form.email': function (newVal, oldVal) {
            this.errors = {};
        }
    },
    methods: {
        register() {
            let vm = this;
            vm.errors = [];
            axios.post(ROOT_URL + "/register", vm.form)
            .then(function (response) {
                vm.$router.push('/home');
            })
            .catch(function (error) {
                vm.errors = error.response.data.errors;
            });
        }
    }
}
</script>