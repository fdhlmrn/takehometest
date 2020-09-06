import AllLoans from './components/AllLoans.vue';
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';
import Logout from './components/auth/Logout.vue';
import AddLoans from './components/AddLoans.vue';
import EditLoan from './components/EditLoan.vue';

export const routes = [
    {
        name: 'home',
        path: '/api/loan',
        component: AllLoans
    },
    {
        name: 'login',
        path: '/api/login',
        component: Login
    },
    {
        name: 'register',
        path: '/api/register',
        component: Register
    },
    {
        name: 'logout',
        path: '/api/logout',
        component: Logout,
        meta: {
            authRequired: true
        }
    },
    {
        name: 'add',
        path: '/api/loan/create',
        component: AddLoans,
        meta: {
            authRequired: true
        }
    },
    {
        name: 'edit',
        path: '/api/loan',
        component: EditLoan,
        meta: {
            authRequired: true
        }
    }
];


