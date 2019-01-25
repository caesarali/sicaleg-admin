require('./bootstrap');
window.Vue = require('vue');

import router from './routes';

// Confirm Message
import Confirm from './commons/Confirm';
Vue.prototype.$confirm = new Confirm;

// Sweetalert2
import swal from 'sweetalert2';
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

// vForm Libs
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// Check Role User
import Role from "./commons/Role";
let role = document.head.querySelector('meta[name="level"]').content;
Vue.prototype.$role = new Role(role);

Vue.component('search-box', require('./components/ui/SearchBox.vue').default);
Vue.component('badge-default', require('./components/ui/badges/BadgeDefault.vue').default);
Vue.component('button-default', require('./components/ui/buttons/ButtonDefault.vue').default);
Vue.component('button-fly', require('./components/ui/buttons/ButtonFly.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    data() {
        return {
            env_level: document.head.querySelector('meta[name="env-level"]').content,
            back_button: false,
            keywords: '',
        }
    },
    router
});
