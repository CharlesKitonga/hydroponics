import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import firstPage from './components/pages/myFirstVuePage';
import newRoutePage from './components/pages/newRoutePage';
import hooks from './components/pages/basic/Hooks';
import methods from './components/pages/basic/Methods';

import usecomp from './vuex/usecomp';

/**Project Admin Pages  */
import home from './components/pages/Home.vue';
import tags from './admin/pages/Tags';
import categories from './admin/pages/Category';
import adminusers from './admin/pages/Adminusers';
import login from './admin/pages/Login';
import role from './admin/pages/Role';
import assignRole from './admin/pages/assignRole'
import createBlog from './admin/pages/createBlog'
import blogs from './admin/pages/Blogs'
import editblog from './admin/pages/editBlog'
import notfound from './admin/pages/notFound'

const routes =[

    /** projects routes start... */
    {
        path: '/',
        component: home,
        name: 'home'
    },

    {
        path: '/tags',
        component: tags,
        name: 'tags'

    },
    {
        path: '/categories',
        component: categories,
        name: 'categories'

    },
    {
        path: '/adminusers',
        component: adminusers,
        name: 'adminusers'

    },
    {
        path: '/login',
        component: login,
        name: 'login'

    },
    {
        path: '/role',
        component: role,
        name: 'role'

    },
    {
        path: '/assignRole',
        component: assignRole,
        name: 'assignRole'

    },
    {
        path: '/createBlog',
        component: createBlog,
        name: 'createBlog'

    },
    {
        path: '/blogs',
        component: blogs,
        name: 'blogs'

    },
    {
        path: '/editblog/:id',
        component: editblog,
        name: 'editblog'

    },
    {
        path: '*',
        component: notfound,
        name: 'notfound'

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
