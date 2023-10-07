import { createRouter, createWebHistory } from 'vue-router';

import Home from '../components/Home.vue';
import Login from '../components/Login.vue';
import CreateSubscriber from '../components/CreateSubscriber.vue';
import BlogList from '../components/BlogList.vue';
import CreateBlog from '../components/CreateBlog.vue';
import UpdateBlog from '../components/UpdateBlog.vue';
import BlogDetails from '../components/BlogDetails.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: Login },
        { path: '/home', component: Home },
        { path: '/login', component: Login },
        { path: '/subscribe', component: CreateSubscriber },
        { path: '/blogs', component: BlogList },
        { path: '/blogs/create', component: CreateBlog },
        { path: '/blogs/:id/edit', component: UpdateBlog },
        { path: '/blogs/:id', component: BlogDetails, props: true },
    ],
});

router.beforeEach((to, from, next) => {
    if (to.path === '/login' || to.path === '/logout' || localStorage.getItem('authToken')) {
        next();
    } else {
        next('/login');
    }
});

export default router;

