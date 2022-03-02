<template>
    <div class="pokedex-app">
        <div class="pokedex-app-sidebar position-fixed h-100 shadow-sm">
            <div class="sb-header p-4">
                <img :src="logo_path" alt="Pokedex">
            </div>
            <div class="position-relative p-4">
                <div class="sb-menu">
                    <router-link v-for="(link, index) in routes" :key="index" role="button" :to="link.path">
                        <div class="sb-menu-item px-4 py-2 mb-2">
                            <b-icon :icon="link.icon" class="position-relative"></b-icon>
                            <span v-text="link.text"></span>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="pokedex-app-container">
            <div class="nav-header position-fixed bg-light shadow-sm">
                <b-container class="py-2">
                    <b-nav pills class="nav-header-alt" align="right">
                        <b-nav-item>
                            <b>{{ full_name }}</b>
                            <b-icon-person-circle class="nav-icon with-text"></b-icon-person-circle>
                        </b-nav-item>
                        <b-nav-item @click="logout()" title="Logout">
                            <b-icon-box-arrow-right class="nav-icon"></b-icon-box-arrow-right>
                        </b-nav-item>
                    </b-nav>
                </b-container>
            </div>

            <b-container class="scrollable-content">
                <router-view></router-view>
            </b-container>
        </div>
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
            routes: [
                {
                    path: '/dashboard/pokemons',
                    text: 'Pokemons',
                    icon: 'grid'
                },
                {
                    path: '/dashboard/trainers',
                    text: 'Trainers',
                    icon: 'people',
                },
            ]
        }
    },
    mounted() {
        this.loadUser();
    },
    computed: {
        full_name() {
            return this.user.first_name + ' ' + this.user.last_name;
        },
        logo_path() {
            return LOGO_ASSET;
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