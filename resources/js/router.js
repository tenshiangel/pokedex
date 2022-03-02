import Login from './pages/Login';
import Registration from './pages/Registration';
import Dashboard from './pages/Dashboard';
import UserList from './pages/UserList';

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
            component: Dashboard
        },
        {
            path: '/users',
            component: UserList,
        }
    ],
}
