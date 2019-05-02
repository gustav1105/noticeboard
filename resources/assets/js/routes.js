import Home from './components/Home'
import Login from './components/Login'

export default {
    routes: [
        {
            path: '/',
            component: Home
        },
        {
            path: '/login',
            component: Login
        }
    ]
}