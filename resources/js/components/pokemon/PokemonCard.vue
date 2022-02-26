<template>
    <b-card 
        v-if="! loading"
        :img-src="pokemon.sprites.front_default"
        img-top
        style="width: 100%;"
        class="mb-2"
    >
        <b-button-group class="card-option-menu no-btn left" size="md">
            <b-icon-heart-fill v-if="faveStatus" @click="setPokemonReaction('favorite')" role="button" v-b-tooltip.hover title="Remove as Favorite" class="card-icon-btn cursor-[opinter" variant="danger"></b-icon-heart-fill>
            <b-icon-heart v-else @click="setPokemonReaction('favorite')" role="button" v-b-tooltip.hover title="Set as Favorite" class="card-icon-btn" variant="light"></b-icon-heart>
        </b-button-group>
        <b-button-group class="card-option-menu right" size="md">
            <b-button @click="setPokemonReaction('like')" class="card-option-btn" v-b-tooltip.hover title="Like this Pokemon" :variant="liked ? 'primary' : ''">
                <b-icon-emoji-smile-fill v-if="liked" class="card-option-icons" variant="light"></b-icon-emoji-smile-fill>
                <b-icon-emoji-smile v-else class="card-option-icons" ></b-icon-emoji-smile>
            </b-button>
            <b-button @click="setPokemonReaction('hate')" class="card-option-btn" v-b-tooltip.hover title="Hate this Pokemon" :variant="hated ? 'warning' : ''">
                <b-icon-emoji-frown-fill v-if="hated" class="card-option-icons" variant="dark"></b-icon-emoji-frown-fill>
                <b-icon-emoji-frown v-else class="card-option-icons"></b-icon-emoji-frown> 
            </b-button>
        </b-button-group>
        <b-card-title class="mb-0">{{ pokemon.name }}</b-card-title>
        <b-card-sub-title>Pokemon No. {{ pokemon.id }}</b-card-sub-title>
        <b-card-text class="mb-2">
            <div class="card-schedule-tags">
                <div v-for="(pkType, index) in pokemon.types" :key="index" class="badge" :class="'badge-' + pkType.type.name">{{ pkType.type.name }}</div>
            </div>
        </b-card-text>
    </b-card>

    <b-card v-else no-body img-top>
        <b-skeleton-img card-img="top" class="loading" animation="wave" aspect="1:1"></b-skeleton-img>
        <b-card-body>
            <b-button-group class="card-option-menu no-btn left" size="md">
                <b-icon-heart role="button" class="card-icon-btn" variant="light"></b-icon-heart>
            </b-button-group>
            <b-button-group class="card-option-menu right" size="md">
                <b-button class="card-option-btn">
                    <b-icon-emoji-smile class="card-option-icons" ></b-icon-emoji-smile>
                </b-button>
                <b-button class="card-option-btn">
                    <b-icon-emoji-frown class="card-option-icons"></b-icon-emoji-frown>
                </b-button>
            </b-button-group>
            <b-card-title class="mb-0">
                <b-skeleton animation="wave" width="100%"></b-skeleton>
            </b-card-title>
            <b-card-sub-title>
                <b-skeleton animation="wave" width="100%"></b-skeleton>
            </b-card-sub-title>
        </b-card-body>
    </b-card>
</template>

<script>
import axios from 'axios';

export default {
    props: ["pokemonRawData", "favorite", "likes", "hates"],
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
            },
            liked: false,
            hated: false,
        }
    },
    computed: {
        faveStatus() {
            return this.favorite ? (this.favorite.pokemon_id == this.pokemon.id) : false;
        },
    },
    watch: {
        'pokemonRawData': function(newVal, oldVal) {
            this.getPokemonDetails();
        },
        'likes': function(newVal, oldVal) {
            this.likeStatus();
        },
        'hates': function(newVal, oldVal) {
            this.hateStatus();
        },
    },
    methods: {
        async getPokemonDetails() {
            let vm = this;
            vm.loading = true;

            axios.get(this.pokemonRawData.url)
            .then(function (response) {
                let data = response.data;

                vm.pokemon = data;
                vm.likeStatus();
                vm.hateStatus();
                vm.loading = false;
            })
        },
        setPokemonReaction(value) {
            let vm = this;
            axios.post(
                ROOT_API + "/pokemon/react",
                {
                    pokemon_id: this.pokemon.id,
                    status: value,
                },
            )
            .then(function (response) {
                vm.$parent.preferences();
            });
        },
        likeStatus() {
            this.liked = false;

            if (this.likes.length > 0) {
                this.likes.forEach(element => {
                    if (element.pokemon_id == this.pokemon.id) {
                        this.liked = true;
                        return false;
                    }
                });
            }
        },
        hateStatus() {
            this.hated = false;

            if (this.hates.length > 0) {
                this.hates.forEach(element => {
                    if (element.pokemon_id == this.pokemon.id) {
                        this.hated = true;
                        return false;
                    }
                });
            }
        },
    },
    mounted() {
        this.getPokemonDetails();
    }
}
</script>

<style lang="scss" scoped>
.card {
    border-radius: 0.65rem;

    &-title {
        text-transform: capitalize;
    }
    &-icon {
        color: white;

        &-btn {
            font-size: 1.5rem;
        }
    }
    &-option {
        &-menu {
            position: absolute;
            top: 0.6rem;
            &.no-btn {
                padding: 0.4rem;
            }
            &.right {
                right: 0.6rem;
            }
            &.left {
                left: 0.6rem;
            }
        }
        &-btn {
            &.btn-warning {
                .card-option-icon {
                    color: var(--bs-body-color);
                    font-size: 1rem;
                }
            }
        }
    }
    &-img-top {
        padding: 0.8rem;

        &:not(.loading) {
            background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/2fb2821a-1406-4a1d-9b04-6668f278e944/d843okx-eb13e8e4-0fa4-4fa9-968a-e0f36ff168de.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzJmYjI4MjFhLTE0MDYtNGExZC05YjA0LTY2NjhmMjc4ZTk0NFwvZDg0M29reC1lYjEzZThlNC0wZmE0LTRmYTktOTY4YS1lMGYzNmZmMTY4ZGUucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.TIK_E5L8dTyBUk_dADA5WkLP8jSJMR7YGJG54KNAido');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    }
    &-body {
        text-align: center;
    }
}
</style>
