import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import firstPage from './components/pages/myFirstVuePage';
import newRoutePage from './components/pages/newRoutePage';
import hooks from './components/pages/basic/Hooks';
import methods from './components/pages/basic/Methods';

import usecomp from './vuex/usecomp';

/**Project Admin Pages  */
import home from './components/pages/Home';
import tags from './admin/pages/Tags';
import categories from './admin/pages/Category';
import adminusers from './admin/pages/Adminusers';
import login from './admin/pages/Login';
import role from './admin/pages/Role';

const routes =[

    /** projects routes start... */
    {
        path: '/',
        component: home
    },

    {
        path: '/tags',
        component: tags
    },
    {
        path: '/categories',
        component: categories
    },
    {
        path: '/adminusers',
        component: adminusers
    },
    {
        path: '/login',
        component: login
    },
    {
        path: '/role',
        component: role
    },


    /** End of projects routes */

    {
        path: '/my-new-vue-route',
        component: firstPage
    },
    {
        path: '/new-route',
        component: newRoutePage
    },
    //understanding vue hooks
    {
        path: '/hooks',
        component: hooks
    },
     //understanding vuex
     {
        path: '/usecomp',
        component: usecomp
    },
    //understanding vue methods
    {
        path: '/methods',
        component: methods
    },

]


export default new Router({
    mode: 'history',
    routes
})
