<template>
    <b-card
        :title="pokemon.name"
        :img-src="pokemon.sprites.other.dream_world.front_default"
        img-alt="Image"
        img-top
        tag="article"
        style="width: 100%;"
        class="mb-2"
    >
        <b-card-text>
            Some quick example text to build on the card title and make up the bulk of the card's content.
        </b-card-text>

        <b-button href="#" variant="primary">More about <span style="text-transform: capitalize;">{{ pokemon.name }}</span></b-button>
    </b-card>
</template>

<script>
import axios from 'axios';

export default {
    props: ["pokemonRawData"],
    data() {
        return {
            pokemon: {
                name: null,
            }
        }
    },
    methods: {
        getPokemonDetails() {
            let vm = this;
            axios.get(this.pokemonRawData.url)
            .then(function (response) {
                let data = response.data;
                console.log(response.data);

                vm.pokemon = data;
            })
        }
    },
    mounted() {
        this.getPokemonDetails();
        // console.log('Component mounted.')
    }
}
</script>

<style lang="scss" scoped>
.card {
    &-title {
        text-align: center;
        text-transform: capitalize;
    }
    &-img-top {
        width: 100%;
        height: 10rem;
        background-image: url('https://i.pinimg.com/originals/df/4e/8b/df4e8ba28f912bf9cdf9fa0dfc196411.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        padding: 0.8rem;
    }
}
</style>
