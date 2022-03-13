window.axios = require('axios');
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Vue = require('vue');
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './App.vue';
import router from './router';
import data from './global';
console.log(data);

axios.get("/user/stays").then( (response) => {
    console.log(response.data);
    // this.stays = response.data[0];
    data.perks = response.data[1];
});

const reservedArea = new Vue({
    el: '#reserved-area',
    render: h => h(App),
    router
});
