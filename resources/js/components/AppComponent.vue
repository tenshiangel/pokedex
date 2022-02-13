<template>
    <div class="container py-4">
        <b-container class="bv-example-row">
            <b-row class="mb-4">
                <b-col></b-col>
                <b-col cols="8">
                    <b-input-group>
                        <b-form-input v-model="tblData.search" @change="searchPokemon()" placeholder="Search a Pokemon"></b-form-input>

                        <template #append>
                            <b-dropdown right variant="outline-secondary" text="Select Type">
                                <b-dropdown-item class="capitalized" v-for="(pkType, index) in types" :key="index">{{ pkType.name }}</b-dropdown-item>
                            </b-dropdown>
                            <b-dropdown right variant="outline-secondary" text="Other options">
                                <b-dropdown-item class="capitalized">Liked Pokemons</b-dropdown-item>
                                <b-dropdown-item class="capitalized">Hated Pokemons</b-dropdown-item>
                            </b-dropdown>
                        </template>
                    </b-input-group>
                </b-col>
                <b-col></b-col>
            </b-row>
            <b-row class="mb-4">
                <b-col>
                    <b-media>
                        <p class="mb-0">
                            <b>Filters:</b>
                        </p>
                        <div class="card-schedule-tags mt-0">
                            <div v-for="(pkType, index) in tblData.types" :key="index" class="badge badge-filter" :class="'badge-' + pkType.name">{{ pkType.name }}
                                <b-icon-x-circle class="badge-close"></b-icon-x-circle>
                            </div>
                        </div>
                    </b-media>
                </b-col>
                <b-col>
                    <b-media v-if="search != ''" class="t-align-right">
                        <h5 class="t-0 mb-0">1-20 of {{ pagination.count }}</h5>
                        <p class="mb-0">Results</p>
                    </b-media>
                </b-col>
            </b-row>
            <b-row>
                <b-col cols="3" v-for="(pokemon, index) in pokemons" :key="index">
                    <pokemon-card :pokemonRawData="pokemon" :favorite="favorite"></pokemon-card>
                </b-col>
            </b-row>
            <!-- <b-row>
                <b-col>
                    <b-pagination
                        v-model="currentPage"
                        :total-rows="rows"
                        :per-page="perPage"
                        aria-controls="my-table"
                    ></b-pagination>
                </b-col>
            </b-row> -->
        </b-container>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            tblData: {
                column: "name",
                dir: "asc",
                draw: 0,
                length: 20,
                search: "",
                types: [
                    {
                        name: "fighting",
                    },
                    {
                        name: "poison",
                    },
                ],
            },
            pagination: {
                count: 0,
                perpage: 20,
                nextPageUrl: "",
                prevPageUrl: "",
            },
            pokemons: [],
            types: [],
            favorite: {
                id: 0,
                url: '',
            },
            likes: [],
            hates: [],
        }
    },
    created() {
        this.delaySearch = _.debounce(this.searchPokemon, 2000);
    },
    watch: {
        "tblData.search": function(newVal, oldVal) {
            if (newVal.trim() != '' && newVal.trim() != oldVal.trim()) {
                this.delaySearch();
            }
            else if (newVal.trim() == '') {
                this.getPokemon();
            }
        },
    },
    methods: {
        getPokemon() {
            let vm = this;
            vm.pokemons = [];

            axios.get('https://pokeapi.co/api/v2/pokemon')
            .then(function (response) {
                let data = response.data;

                vm.pagination.count = data.count;
                vm.pokemons = data.results;
            })
        },
        searchPokemon() {
            let vm = this;
            vm.pokemons = [];

            axios.get('https://pokeapi.co/api/v2/pokemon/' + vm.tblData.search)
            .then(function (response) {
                let data = response.data;
                let rawData = [
                    {
                        name: data.name,
                        url: 'https://pokeapi.co/api/v2/pokemon/' + data.id
                    }
                ]

                vm.pokemons = rawData;
            })
        },
        getPokemonTypes() {
            let vm = this;
            axios.get('https://pokeapi.co/api/v2/type')
            .then(function (response) {
                let data = response.data;

                vm.types = data.results;
            })
        },
        async isFavorite() {
            let vm = this;
            axios.get(
                ROOT_API + "/favorite/get",
                {
                    params: {
                        user_id: AUTH_ID,
                    },
                }
            )
            .then(function (response) {
                // console.log("response:", response);
                let data = response.data.data;
                vm.favorite = data ? data : {
                    id: 0,
                    url: '',
                };
            });
        },
        // async isLiked() {
        //     let vm = this;
        //     axios.get(
        //         ROOT_API + "/favorite/get",
        //         {
        //             params: {
        //                 user_id: AUTH_ID,
        //             },
        //         }
        //     )
        //     .then(function (response) {
        //         let data = response.data;
        //         console.log(data);
        //         // vm.likes = data;
        //     });
        // },
    },
    mounted() {
        this.getPokemon();
        this.getPokemonTypes();
        this.isFavorite();
    }
}
</script>

<style lang="scss" scoped>
.t-align-right {
    text-align: right;
}
</style>