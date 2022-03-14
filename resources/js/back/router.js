import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

// import Register from './components/pages/Register.vue';

import Dashboard from './components/pages/Dashboard.vue';
import Stays from './components/pages/stays/Stays.vue';
import CreateStay from './components/pages/stays/CreateStay.vue';
import EditStay from './components/pages/stays/EditStay.vue';
import SponsorPackages from './components/pages/SponsorPackages.vue';
import Statistics from './components/pages/Statistics.vue';
import NotFound from './components/pages/NotFound.vue';


const router = new VueRouter({
    mode: "history",
    routes: [

        {
             path:'/user/',
             name:'dashboard',
             component: Dashboard
        },

        {
            path:'/user/my-apartments',
            name:'stays',
            component: Stays
        },

        {
            path:'/user/new-apartment',
            name:'create-stay',
            component: CreateStay
        },

        {
            path:'/user/edit-apartment/:stay',
            name:'edit-stay',
            component: EditStay
        },

        {
            path:'/user/sponsor',
            name:'sponsor',
            component: SponsorPackages
        },

        {
            path:'/user/statistics/:stay',
            name:'statistics',
            component: Statistics
        },     

        {
            path:'/user/404',
            name:'404',
            component: NotFound
        },     

    ]
});

export default router