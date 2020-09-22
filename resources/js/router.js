import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import firstPage from './components/pages/myFirstVuePage';
import newRoutePage from './components/pages/newRoutePage';
import hooks from './components/pages/basic/Hooks';
import methods from './components/pages/basic/Methods';

/**Project Pages  */
import home from './components/pages/Home';
import tags from './admin/pages/Tags';
import categories from './admin/pages/Category';

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
