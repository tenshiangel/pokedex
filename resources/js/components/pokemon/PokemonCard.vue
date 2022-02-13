<template>
    <b-card 
        :img-src="pokemon.sprites.front_default"
        img-top
        style="width: 100%;"
        class="mb-2"
    >
        <b-button-group class="card-option-menu" size="md" vertical>
            <b-button @click="setFavorite()" class="card-option-btn" :variant="faveStatus">
                <b-icon-heart-fill class="card-option-icons"></b-icon-heart-fill>
            </b-button>
            <b-button class="card-option-btn" :variant="liked ? 'success' : ''">
                <b-icon-emoji-smile class="card-option-icons"></b-icon-emoji-smile>
            </b-button>
            <b-button  class="card-option-btn" :variant="hated ? 'warning' : ''">
                <b-icon-emoji-angry class="card-option-icons"></b-icon-emoji-angry> 
            </b-button>
        </b-button-group>
        <b-card-title class="mb-0">{{ pokemon.name }}</b-card-title>
        <b-card-sub-title>Pokemon No. {{ pokemon.id }}</b-card-sub-title>
        <b-card-text class="mb-2">
            <div class="card-schedule-tags">
                <div v-for="(pkType, index) in pokemon.types" :key="index" class="badge" :class="'badge-' + pkType.type.name">{{ pkType.type.name }}</div>
            </div>
        </b-card-text>

        <b-button pill variant="outline-primary">More about <span style="text-transform: capitalize;">{{ pokemon.name }}</span></b-button>
    </b-card>
</template>

<script>
import axios from 'axios';

export default {
    props: ["pokemonRawData", "favorite"],
    data() {
        return {
            loading: false,
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
            },
            // favorite: false,
            liked: false,
            hated: false,
        }
    },
    computed: {
        faveStatus() {
            return this.favorite ? (this.favorite.url == this.pokemonRawData.url ? 'danger' : '') : '';
        }
    },
    watch: {
        'pokemonRawData': function(newVal, oldVal) {
            this.getPokemonDetails();
        },
        'pokemon': function(newVal, oldVal) {
            // this.isFavorite();
            // this.isLiked();
            this.isHated();
        }
    },
    methods: {
        async getPokemonDetails() {
            let vm = this;
            axios.get(this.pokemonRawData.url)
            .then(function (response) {
                let data = response.data;

                vm.pokemon = data;
            })
        },
        async isHated() {
            // axios.get(this.pokemonRawData.url)
            // .then(function (response) {
            //     let data = response.data;

            //     vm.pokemon = data;
            // })
            console.log("isHated()");
        },
        setFavorite() {
            let vm = this;
            axios.post(
                ROOT_API + "/favorite/set",
                {
                    user_id: AUTH_ID,
                    favorite_pokemon_url: this.pokemonRawData.url
                },
                {
                    headers: {
                        'Access-Control-Allow-Origin': '*'
                    }
                }
            )
            .then(function (response) {
                // console.log("response:", response);
                let data = response.data.data;
                
                // if (response.status != 204) {
                //     vm.toast('b-toaster-top-right', (response.status != 204 ? 'Saved as your favorite' : 'Removed from favorite'));
                // }
                // if (data.url == vm.pokemonRawData.url) {
                //     vm.$parent.isFavorite();
                // }
                vm.toast('b-toaster-top-right', (response.status != 204 ? 'Saved as your favorite' : 'Removed from favorite'));
                vm.$parent.isFavorite();
            })
        },
        toast(toaster, message) {
            this.$bvToast.toast(message, {
                title: 'Successfully Updated',
                toaster: toaster,
                solid: true,
                appendToast: false
            })
        }
    },
    mounted() {
        this.getPokemonDetails();
    }
}
</script>

<style lang="scss" scoped>
.card {
    position: relative;

    &-title {
        text-transform: capitalize;
    }
    &-option {
        &-menu {
            position: absolute;
            top: 0.6rem;
            right: 0.6rem;
        }
        &-btn {
            &.btn-warning {
                .card-option-icon {
                    color: var(--bs-body-color);
                }
            }
        }
        &-icon {
            color: white;
        }
    }
    &-img-top {
        background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/2fb2821a-1406-4a1d-9b04-6668f278e944/d843okx-eb13e8e4-0fa4-4fa9-968a-e0f36ff168de.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzJmYjI4MjFhLTE0MDYtNGExZC05YjA0LTY2NjhmMjc4ZTk0NFwvZDg0M29reC1lYjEzZThlNC0wZmE0LTRmYTktOTY4YS1lMGYzNmZmMTY4ZGUucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.TIK_E5L8dTyBUk_dADA5WkLP8jSJMR7YGJG54KNAido');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        padding: 0.8rem;
    }
    &-body {
        text-align: center;
    }
}
</style>
