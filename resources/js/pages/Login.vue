<template>
    <b-form @submit.prevent="login()" class="col-md-12">
        <div class="app-form">
            <div class="row">
                <div class="col-md-8 p-0">
                    <div class="at-left shadow-lg position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white"></div>
                </div>

                <div class="col-md-4 p-0 d-flex justify-content-center align-items-center">
                    <div class="at-right" style="width: 80%">
                        <h2 class="mb-4">Login</h2>

                        <label class="mb-2 app-form-label" for="email">Email</label>
                        <b-form-group class="position-relative mb-3">
                            <b-form-input :state="emailState" v-model="form.email" id="email" type="email" class="app-form-input has-icon" placeholder="Email address" aria-describedby="email-feedback" required></b-form-input>
                            <b-icon-at class="position-absolute field-inline left"></b-icon-at>
                            <b-form-invalid-feedback id="email-feedback">
                                This credential doesn't match to our records
                            </b-form-invalid-feedback>
                        </b-form-group>

                        <label class="mb-2 app-form-label" for="password">Password</label>
                        <b-form-group class="position-relative mb-3">
                            <b-form-input v-model="form.password" id="password" :type="isRevealed ? 'text' : 'password'" class="app-form-input has-icon right" placeholder="Password" required></b-form-input>
                            <b-icon-key class="position-absolute field-inline left"></b-icon-key>
                            <b-icon @click="reveal()" :icon="isRevealed ? 'eye' : 'eye-slash'" role="button" class="position-absolute field-inline right"></b-icon>
                        </b-form-group>
                        <div class="row my-4">
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <a class="form-redirect-link" style="float: right;" href="#">Forgot password?</a>
                            </div>
                        </div>

                        <b-overlay
                            :show="loading"
                            rounded
                            opacity="0.4"
                            spinner-small
                            spinner-variant="primary"
                            @hidden="afterLoad"
                            >
                            <button class="btn btn-success app-form-btn shadow border-0 py-2 text-uppercase" :disabled="loading">
                                Login
                            </button>
                        </b-overlay>

                        <div class="alt-sign-in text-center my-4">
                            <h1 class="position-relative text-center">
                                <span class="py-2 px-4 position-relative text-uppercase">Or sign-in via</span>
                            </h1>
                            <span class="btn logo-sign-in p-2 d-inline-block mx-2">
                                <b-icon-facebook class="d-block"></b-icon-facebook>
                            </span>
                            <span class="btn logo-sign-in p-2 d-inline-block mx-2">
                                <b-icon-google class="d-block"></b-icon-google>
                            </span>
                            <span class="btn logo-sign-in p-2 d-inline-block mx-2">
                                <b-icon-github class="d-block"></b-icon-github>
                            </span>
                        </div>
                        <p class="text-center">
                            Not a member yet?
                            <router-link role="button" class="form-redirect-link" to="/register">Sign up now!</router-link>
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
            isRevealed: false,
            loading: false,
            form: {
                email: null,
                password: null,
            },
            errors: {},
        }
    },
    computed: {
        emailState() {
            return this.errors ? (this.errors.email ? false : null) : null;
        }
    },
    watch: {
        'form.email': function (newVal, oldVal) {
            this.errors = {};
        }
    },
    methods: {
        reveal() {
            this.isRevealed = !this.isRevealed;
        },
        login() {
            let vm = this;
            
            if (vm.loading) {
                return;
            }
            
            vm.loading = true;
            vm.errors = [];
            axios.post(ROOT_URL + "/login", vm.form)
            .then(function (response) {
                setTimeout(() => {
                    vm.$router.push('/dashboard/pokemons');
                    vm.loading = false;
                }, 1500)
            })
            .catch(function (error) {
                vm.errors = error.response.data.errors;
                vm.loading = false;
            });
        },
        afterLoad() {
            this.$refs.button.focus()
        }
    }
}
</script>