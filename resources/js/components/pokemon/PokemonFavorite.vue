<template>
    <b-media class="trainer-header text-center">
        <template #aside>
            <b-overlay
                v-if="loading"
                :show="loading"
                rounded
                opacity="0.4"
                spinner-small
                variant="dark"
                spinner-variant="light"
                >
                <div class="img-favorite"></div>
            </b-overlay>
            <img v-else :src="pokemon.sprites.front_default" :alt="pokemon.name" class="img-favorite">
        </template>
        <b-media-body class="text-uppercase">
            <b-card no-body class="fave-card p-1">
                <h6 v-if="loading" class="my-0">&nbsp;</h6>
                <h6 v-else class="my-0 position-relative text-center">
                    <b-icon-heart-fill class="card-icon position-absolute" variant="danger"></b-icon-heart-fill>
                    {{ pokemon.name }}
                </h6>
            </b-card>
        </b-media-body>
    </b-media>
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

<style lang="scss" scoped>
.img-favorite {
    width: 8rem;
    height: 8rem;
}
.fave-card {
    color: black;

    h6 {
        line-height: 1.4rem;
        text-align: left;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;

        .card-icon {
            margin: 0 0.5rem;
            top: 0.3rem;
            left: -0.3rem;
        }
    }
}
</style>