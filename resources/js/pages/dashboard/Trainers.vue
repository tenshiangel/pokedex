<template>
    <b-container class="p-0 position-relative">
        <b-row class="mb-4">
            <b-col></b-col>
            <b-col cols="8">
                <b-form-group class="position-relative mb-3">
                    <b-form-input v-model="tblData.search" type="text" class="app-form-input has-icon" placeholder="Search a Trainer..." required></b-form-input>
                    <b-icon-search class="position-absolute field-inline left icon-customize"></b-icon-search>
                </b-form-group>
            </b-col>
            <b-col></b-col>
        </b-row>

        <b-container class="my-4">
            <b-row>
                <b-col v-for="(trainer, index) in trainers" :key="index" cols="6">
                    <b-card no-body class="trainer-card mb-3 position-relative overflow-hidden shadow-sm" bg-variant="light" text-variant="dark">
                        <div class="card-bg-skewer position-absolute h-100"></div>
                        <div class="card-bg-skewer filler position-absolute h-100"></div>
                        <b-card-body style="z-index: 2;">
                            <b-row>
                                <b-col cols="4">
                                    <b-media class="trainer-header text-uppercase mb-4">
                                        <p class="mb-1">Trainer # TR-{{ index + 1 }}</p>
                                        <h6 class="mb-0">{{ trainer.first_name + ' ' + trainer.last_name }}</h6>
                                    </b-media>
                                    <pokemon-fave :pokemonData="trainer.favorite"></pokemon-fave>
                                </b-col>
                                <b-col></b-col>
                                <b-col cols="7">
                                    <b-row class="mb-2">
                                        <b-col cols="12">
                                            <div class="trainer-header-bracket">
                                                <h3 class="position-relative text-center">
                                                    <span class="py-2 px-4 position-relative text-uppercase">Liked Pokemons</span>
                                                </h3>
                                            </div>
                                        </b-col>
                                        <b-col v-for="(pokemon, index) in trainer.liked_pokemons" :key="index">
                                            <pokemon-pref :pokemonData="pokemon"></pokemon-pref>
                                        </b-col>
                                        <b-col v-for="i in (3 - trainer.liked_pokemons.length)" :key="i">
                                            <b-img thumbnail fluid-grow rounded blank blank-color="#d4d6d9"></b-img>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col cols="12">
                                            <div class="trainer-header-bracket">
                                                <h3 class="position-relative text-center">
                                                    <span class="py-2 px-4 position-relative text-uppercase">Hated Pokemons</span>
                                                </h3>
                                            </div>
                                        </b-col>
                                        <b-col v-for="(pokemon, index) in trainer.hated_pokemons" :key="index">
                                            <pokemon-pref :pokemonData="pokemon"></pokemon-pref>
                                        </b-col>
                                        <b-col v-for="i in (3 - trainer.hated_pokemons.length)" :key="i">
                                            <b-img thumbnail fluid-grow rounded blank blank-color="#d4d6d9"></b-img>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card>
                </b-col>
            </b-row>
        </b-container>
    </b-container>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            loading: true,
            trainers: [],
            tblData: {
                column: "name",
                dir: "asc",
                search: "",
                types: [],
            },
            pagination: {
                count: 0,
                perpage: 12,
                page: 0,
            },
        }
    },
    methods: {
        async getUsers() {
            let vm = this;
            axios.get(ROOT_API + "/pokemon/preferences/list")
            .then(function (response) {
                let data = response.data;
                vm.trainers = data;
            });
        }
    },
    mounted() {
        this.getUsers();
    }
}
</script>