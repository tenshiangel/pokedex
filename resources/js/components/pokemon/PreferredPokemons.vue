<template>
    <b-overlay
        v-if="loading"
        :show="loading"
        rounded
        opacity="0.4"
        spinner-small
        variant="dark"
        spinner-variant="light"
        >
        <b-img thumbnail fluid-grow rounded blank blank-color="#d4d6d9" class="shadow-sm"></b-img>
    </b-overlay>
    <b-img v-else thumbnail fluid-grow rounded class="shadow-sm" :src="pokemon.sprites.front_default"></b-img>
</template>

<script>
export default {
    props: ["pokemonData"],
    data() {
        return {
            loading: true,
            pokemon: {
                id: 0,
                name: null,
                sprites: {
                    front_default: null
                },
                types: [
                    {
                        type: {
                            name: null,
                        }
                    }
                ]
            }
        }
    },
    mounted() {
        this.getPokemonImg();
    },
    methods: {
        async getPokemonImg() {
            let vm = this;
            vm.loading = true;

            axios.get('https://pokeapi.co/api/v2/pokemon/' + vm.pokemonData.pokemon_id)
            .then(function (response) {
                vm.pokemon = response.data;
                vm.loading = false;
            });
        },
    }
}
</script>