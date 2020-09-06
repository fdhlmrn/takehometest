
require('./bootstrap');

window.Vue = require('vue');

import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import {store} from './store/store'

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (!to.meta.authRequired) {
        next();
    } else if (store.getters.loggedIn) {
        next();
    } else {
        next({
            name: 'home'
        });
    }
});
const app = new Vue({
    el: '#app',
    router: router,
    store: store,
    render: h => h(App),
});
