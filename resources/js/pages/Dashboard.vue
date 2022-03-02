<template>
    <general-view>
        <b-container class="bv-example-row py-4">
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
                    <b-media v-if="pokemons.length > 0">
                        <h5 class="t-0 mb-0">{{ offset + 1 }}-{{ offset + pagination.perpage }} of {{ pagination.count }}</h5>
                        <p class="mb-0">Results</p>
                    </b-media>
                </b-col>
                <b-col>
                    <b-button-group style="float: right;">
                        <b-button @click="paginate('prev')">Prev</b-button>
                        <b-button @click="paginate('next')">Next</b-button>
                    </b-button-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col cols="4" sm="4" md="3" v-for="(pokemon, index) in pokemons" :key="index">
                    <pokemon-card :pokemonRawData="pokemon" :favorite="favorite" :likes="likes" :hates="hates"></pokemon-card>
                </b-col>
            </b-row>
        </b-container>
    </general-view>
</template>

<script>
import GeneralView from '../layouts/GeneralView';
import axios from 'axios';

export default {
    components: { GeneralView },
    data() {
        return {
            tblData: {
                column: "name",
                dir: "asc",
                draw: 0,
                length: 12,
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
                perpage: 12,
                page: 0,
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
        this.delaySearch = _.debounce(this.searchPokemon, 1500);
        this.delayLoad = _.debounce(this.getPokemonList, 1000);
    },
    watch: {
        "tblData.search": function(newVal, oldVal) {
            if (! ['', undefined, null].includes(newVal.trim()) && newVal.trim() != oldVal.trim()) {
                this.delaySearch();
            }
            else if (['', undefined, null].includes(newVal.trim())) {
                this.delayLoad();
            }
        },
        "pagination.page": function(newVal, oldVal) {
            this.pokemons = [];
            this.delayLoad();
        },
    },
    computed: {
        offset() {
            return this.pagination.perpage * this.pagination.page;
        }
    },
    methods: {
        getPokemonList() {
            let vm = this;
            vm.pokemons = [];

            axios.get('https://pokeapi.co/api/v2/pokemon?limit=12&offset=' + vm.offset)
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
        pokemonTypes() {
            let vm = this;
            axios.get('https://pokeapi.co/api/v2/type')
            .then(function (response) {
                let data = response.data;

                vm.types = data.results;
            })
        },
        async preferences() {
            let vm = this;
            axios.get(ROOT_API + "/pokemon/preferences/user")
            .then(function (response) {
                let data = response.data.data;

                vm.favorite = data.favorite;
                vm.likes = data.likes;
                vm.hates = data.hates;
            });
        },
        paginate(value) {
            switch(value) {
                case 'prev':
                    if (this.pagination.page <= 0) {
                        return;
                    }
                    this.pagination.page--;
                    break;
                case 'next':
                    if (this.pagination.count - this.offset < this.pagination.perpage) {
                        return;
                    }
                    this.pagination.page++;
                    break;
            }
        }
    },
    mounted() {
        this.getPokemonList();
        this.pokemonTypes();
        this.preferences();
    }
}
</script>

<style lang="scss" scoped>
.t-align-right {
    text-align: right;
}
</style>