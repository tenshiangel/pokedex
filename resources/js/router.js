import Login from './pages/Login';
import Registration from './pages/Registration';
import GeneralView from './layouts/GeneralView';
import Pokemons from './pages/dashboard/Pokemons';
import Trainers from './pages/dashboard/Trainers';

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            redirect: '/login'
        },
        {
            path: '/login',
            component: Login
        },
        {
            path: '/register',
            component: Registration
        },
        {
            path: '/dashboard',
            component: GeneralView,
            children: [
                {
                    path: 'pokemons',
                    component: Pokemons
                },
                {
                    path: 'trainers',
                    component: Trainers
                },
            ]          
        },
    ],
}
