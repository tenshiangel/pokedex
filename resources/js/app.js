/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import { BootstrapVue, IconsPlugin, SkeletonPlugin, ToastPlugin } from 'bootstrap-vue'
import VueRouter from 'vue-router';
import routes from './router';

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('pokemon-card', require('./components/pokemon/PokemonCard.vue').default);
Vue.component('pokemon-fave', require('./components/pokemon/PokemonFavorite.vue').default);
Vue.component('pokemon-pref', require('./components/pokemon/PreferredPokemons.vue').default);

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueRouter);
Vue.use(SkeletonPlugin);
Vue.use(ToastPlugin);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
});
