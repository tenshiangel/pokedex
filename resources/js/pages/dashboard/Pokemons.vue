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
        <b-row class="mb-4">
            <b-col cols="4" sm="4" md="3" v-for="(pokemon, index) in pokemons" :key="index">
                <pokemon-card :pokemonRawData="pokemon" :favorite="favorite" :likes="likes" :hates="hates"></pokemon-card>
            </b-col>
        </b-row>

        <b-container class="position-fixed pagintation mb-3" style="right: 0; bottom: 0; z-index: 10; width: calc(100% - 20rem)">
            <b-row>
                <b-col></b-col>
                <b-col>
                    <b-overlay
                        :show="loading"
                        rounded
                        opacity="0.4"
                        spinner-small
                        spinner-variant="primary"
                        >
                        <div class="card card-custom-gradient py-2 shadow-sm">
                            <b-row>
                                <b-col class="text-center">
                                    <b-button class="btn btn-circle btn-hotkey" variant="dark" @click="paginate('prev')">
                                        <b-icon-chevron-double-left></b-icon-chevron-double-left>
                                    </b-button>
                                </b-col>
                                <b-col class="text-center" cols="6">
                                    <b-media v-if="! loading">
                                        <h5 class="t-0 mb-0">{{ offset + 1 }}-{{ offset + pagination.perpage }} of {{ pagination.count }}</h5>
                                        <p class="mb-0" style="font-size: 80%;">Pokemons</p>
                                    </b-media>
                                </b-col>
                                <b-col class="text-center">
                                    <b-button class="btn btn-circle btn-hotkey" variant="dark" @click="paginate('next')">
                                        <b-icon-chevron-double-right></b-icon-chevron-double-right>
                                    </b-button>
                                </b-col>
                            </b-row>
                        </div>
                    </b-overlay>
                </b-col>
                <b-col></b-col>
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
                draw: 0,
                length: 12,
                search: "",
                types: [],
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
            this.loading = true;
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
            vm.loading = true;
            vm.pokemons = [];

            axios.get('https://pokeapi.co/api/v2/pokemon?limit=12&offset=' + vm.offset)
            .then(function (response) {
                let data = response.data;

                vm.pagination.count = data.count;
                vm.pokemons = data.results;
                vm.loading = false;
            })
        },
        searchPokemon() {
            let vm = this;
            vm.pagination.page = 0;
            vm.loading = true;
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
                vm.loading = false;
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
        this.preferences();
    }
}
</script>

<style lang="scss" scoped>
.t-align-right {
    text-align: right;
}
.icon-customize {
    font-size: 1.65rem;
    top: 0.65rem;
    left: 0.85rem !important;
}
.card-custom-gradient {
    background: linear-gradient(45deg, #8D334C, #CF6964);

    .media {
        color: white;
    }
}
</style>