import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Home from './components/pages/home/Home.vue';
import Apartment from './components/pages/Apartment.vue';
import AdvancedSearch from './components/pages/AdvancedSearch.vue';

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path:'/',
            name:'home',
            component: Home
        },
        {
            path:'/apartment/:stay',
            name:'apartment',
            component: Apartment
        },
        {
            path: '/search',
            name: 'advancedSearch',
            component: AdvancedSearch
        }
    ]
});

export default router