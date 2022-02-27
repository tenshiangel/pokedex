import AppComponent from './components/AppComponent';
import Login from './pages/Login';
import Registration from './pages/Registration';
import LandingPage from './pages/LandingPage';
import Profile from './pages/Profile';

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
            path: '/home',
            component: AppComponent
        },
    ],
}
