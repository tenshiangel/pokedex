<template>
    <div class="container py-4">
        <b-container class="bv-example-row">
            <b-row>
                <b-col cols="3" v-for="(pokemon, index) in pokemons" :key="index">
                    <!-- <b-card
                        :title="pokemon.name"
                        img-src="https://picsum.photos/600/300/?image=25"
                        img-alt="Image"
                        img-top
                        tag="article"
                        style="width: 100%;"
                        class="mb-2"
                    >
                        <b-card-text>
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </b-card-text>

                        <b-button href="#" variant="primary">Go somewhere</b-button>
                    </b-card> -->
                    <pokemon-card :pokemonRawData="pokemon"></pokemon-card>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            pokemons: [],
        }
    },
    methods: {
        getPokemon() {
            let vm = this;
            axios.get('https://pokeapi.co/api/v2/pokemon')
            .then(function (response) {
                let data = response.data;

                vm.pokemons = data.results;
            })
        }
    },
    mounted() {
        this.getPokemon();
    }
}
</script>