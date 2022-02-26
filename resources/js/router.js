import AppComponent from './components/AppComponent';

export default {
    mode: 'history',
    routes: [
        {
            path: 'home',
            name: 'home',
            component: AppComponent
        },
        {
            path: '/',
            component: AppComponent,
        }
    ],
}
