require('./bootstrap');
window.Vue = require('vue');

import router from './routes';

// Check Role User
import Role from "./commons/Role";
let role = document.head.querySelector('meta[name="level"]').content;
Vue.prototype.$role = new Role(role);

Vue.component('badge-default', require('./components/ui/badges/BadgeDefault.vue'));

const app = new Vue({
    el: '#app',
    router
});
