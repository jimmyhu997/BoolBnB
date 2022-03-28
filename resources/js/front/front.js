window.axios = require('axios');
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Vue = require('vue');
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};
window.dayJs = require('dayjs')
window.externalAxios = axios.create()
delete externalAxios.defaults.headers.common['X-CSRF-TOKEN']
delete externalAxios.defaults.headers.common['X-Requested-With']

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './App.vue';
import router from './router';
import data from '../vue-commons/vueGlobal';
data.loggedUserId = document.querySelector('meta[name="userID"]').getAttribute('content');
data.loggedUserName = document.querySelector('meta[name="userName"]').getAttribute('content');
data.loggedUserEmail = document.querySelector('meta[name="userEmail"]').getAttribute('content');

const publicArea = new Vue({
    el: '#public-area',
    render: h => h(App),
    router
});
