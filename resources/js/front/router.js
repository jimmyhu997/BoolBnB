import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

// import Register from './components/pages/Register.vue';

import Home from './components/pages/Home.vue';

const router = new VueRouter({
    mode: "history",
    routes: [

        {
             path:'/',
             name:'home',
             component: Home
        }
        // {
        //     path:'/register',
        //     name:'register',
        //     component: Register
        // }
    ]
});

export default router