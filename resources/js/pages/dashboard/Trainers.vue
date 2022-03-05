<template>
    <b-container class="p-0 position-relative">
        <b-row class="mb-4">
            <b-col></b-col>
            <b-col cols="8">
                <b-form-group class="position-relative mb-3">
                    <b-form-input v-model="tblData.search" type="text" class="app-form-input has-icon" placeholder="Search a Pokemon..." required></b-form-input>
                    <b-icon-search class="position-absolute field-inline left icon-customize"></b-icon-search>
                </b-form-group>
            </b-col>
            <b-col></b-col>
        </b-row>

        <b-container class="my-4">
            <b-row>
                <b-col v-for="index in 4" :key="index" cols="6">
                    <b-card no-body class="trainer-card mb-3 position-relative overflow-hidden shadow-sm" bg-variant="light" text-variant="dark">
                        <div class="card-bg-skewer position-absolute h-100"></div>
                        <div class="card-bg-skewer filler position-absolute h-100"></div>
                        <b-card-body style="z-index: 2;">
                            <b-row>
                                <b-col cols="4">
                                    <b-media class="trainer-header text-uppercase mb-4">
                                        <p class="mb-1">Trainer # 002940{{ index }}</p>
                                        <h6 class="mb-0">Pokemon Trainer</h6>
                                    </b-media>
                                    <b-media class="trainer-header text-center">
                                        <template #aside>
                                            <b-icon-person-circle class="trainer-icon-placeholder"></b-icon-person-circle>
                                        </template>
                                        <b-media-body>
                                            <div class="trainer-header-bracket mt-4">
                                                <h3 class="position-relative text-center m-0">
                                                    <span class="py-2 px-4 position-relative text-uppercase">Favorite</span>
                                                </h3>
                                            </div>
                                        </b-media-body>
                                    </b-media>
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
                                        <b-col>
                                            <b-card></b-card>
                                        </b-col>
                                        <b-col>
                                            <b-card></b-card>
                                        </b-col>
                                        <b-col>
                                            <b-card></b-card>
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
                                        <b-col>
                                            <b-card></b-card>
                                        </b-col>
                                        <b-col>
                                            <b-card></b-card>
                                        </b-col>
                                        <b-col>
                                            <b-card></b-card>
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
        getUsers() {
            
        }
    }
}
</script>