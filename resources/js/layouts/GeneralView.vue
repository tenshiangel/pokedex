<template>
    <div class="base-comp">
        <div class="nav-header position-fixed w-100 bg-success text-light shadow-sm">
            <b-container class="py-2">
                <b-nav pills class="nav-header-alt" align="right">
                    <b-nav-item>{{ full_name }}
                        <b-icon-person-circle class="nav-icon with-text"></b-icon-person-circle>
                    </b-nav-item>
                    <b-nav-item @click="logout()" title="Logout">
                        <b-icon-box-arrow-right class="nav-icon"></b-icon-box-arrow-right>
                    </b-nav-item>
                </b-nav>
            </b-container>
        </div>

        <b-container class="pt-5">
            <slot></slot>
        </b-container>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: {
                first_name: null,
                last_name: null,
                birthdate: null,
            },
            errors: [],
        }
    },
    mounted() {
        this.loadUser();
    },
    computed: {
        full_name() {
            return this.user.first_name + ' ' + this.user.last_name;
        }
    },
    methods: {
        loadUser() {
            let vm = this;
            vm.loading = true;

            axios.get(ROOT_API + "/user")
            .then(function (response) {
                vm.user = response.data.data;
            })
        },
        logout() {
            let vm = this;
            vm.errors = [];
            axios.post(ROOT_URL + "/logout", {})
            .then(function (response) {
                setTimeout(() => {
                    vm.$router.push('/');
                }, 1250)
            })
            .catch(function (error) {
                vm.errors = error.response.data.errors;
            });
        },
    }
}
</script>

<style lang="scss" scoped>
.nav-header {
    z-index: 100;
}
</style>