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

// Badge Components =======================================================================
Vue.component('badge-default', require('./components/ui/badges/BadgeDefault.vue').default);

// Button Components =========================================================================
Vue.component('button-default', require('./components/ui/buttons/ButtonDefault.vue').default);
Vue.component('button-success', require('./components/ui/buttons/ButtonSuccess.vue').default);
Vue.component('button-outline-success', require('./components/ui/buttons/ButtonOutlineSuccess.vue').default);
Vue.component('button-fly', require('./components/ui/buttons/ButtonFly.vue').default);

// Modal Components
Vue.component('modal', require('./components/ui/modals/ModalDefault.vue').default);

// Table Components ================================================================
Vue.component('row-empty', require('./components/ui/tables/RowEmpty.vue').default);

// Other Components ==================================================================
Vue.component('pulse-loader', require('vue-spinner/src/PulseLoader.vue').default);
Vue.component('app-loader', require('./components/ui/AppLoader.vue').default);
Vue.component('search-box', require('./components/ui/SearchBox.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Filters
Vue.filter('gender', function (value) {
    if (value == 'p') {
        return 'Perempuan'
    } else {
        return 'Laki-laki'
    }
})
Vue.filter('marital', function (value) {
    switch (value) {
        case 's':
            return 'Sudah Menikah';
        case 'p':
            return 'Pernah Menikah';

        default:
            return 'Belum Menikah';
    }
})

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
