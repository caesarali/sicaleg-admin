require('./bootstrap');
import _ from "lodash";
import Vue from 'vue'
import App from './App.vue';
import Chart from 'chart.js';
import router from './routes';
import store from './stores';
import { mapGetters, mapState } from 'vuex'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

import VueLazyLoad from 'vue-lazyload';
Vue.use(VueLazyLoad, {
    preLoad: 1.3,
});

import Confirm from './commons/Confirm';
Vue.prototype.$confirm = new Confirm;

import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate)

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
import Axios from "axios";
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('modal', require('./components/ui/modals/ModalDefault.vue').default);
Vue.component('button-default', require('./components/ui/buttons/ButtonDefault.vue').default);
Vue.component('row-empty', require('./components/ui/tables/RowEmpty.vue').default);
Vue.component('search-box', require('./components/ui/SearchBox.vue').default);
Vue.component('light-box', require('./components/ui/LightBox.vue').default);

// Filters
Vue.filter('gender', function (value) {
    return value == 'p' ? 'Perempuan' : 'Laki-laki'
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
    components: { App },
    router,
    store,
    data() {
        return {
            env_level: document.head.querySelector('meta[name="env-level"]').content,
            back_button: false,
            keywords: '',
            isSearching: false,
            isLoading: true,
            user: {
                id: '',
                name: '',
                email: '',
                username: '',
                roles: [],
            },
            notifications: []
        }
    },
    computed: {
        ...mapGetters(['isAuth']),
        ...mapState(['token']),
    },
    methods: {
        getUserLogin() {
            axios.get('/user')
            .then(({ data }) => this.user = data)
        },
        getNotifications() {
            axios.get('/notifications')
            .then(({ data }) => {
                this.notifications = data
                if (data.length) {
                    this.spawnNotification(data.length + ' Pendukung baru ditambahkan.', 'SIMCALEG')
                }
            })
        },
        spawnNotification(body, title) {
            Notification.requestPermission(function(result) {
                if (result === 'granted') {
                    var options = {
                        body: body,
                        icon: '/icons/android-icon-192x192.png'
                    };
                    var n = new Notification(title, options);
                }
            })
        },
        markAsReadNotification() {
            if (this.notifications.length > 0) {
                axios.get('/notifications?markAs=read')
                .then(({ data }) => {
                    this.notifications = data
                })
            }
        },
        initialLister() {
            if (this.isAuth && this.user.id != '') {
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: process.env.MIX_PUSHER_APP_KEY,
                    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                    encrypted: true,
                    auth: {
                        headers: {
                            Authorization: 'Bearer ' + this.token
                        },
                    },
                });

                window.Echo.private('App.Models.User.' + this.user.id)
                .notification(() => {
                    this.getNotifications()
                })
            }
        }
    },
    watch: {
        "user.id"() {
            this.initialLister()
        }
    },
    created() {
        if (this.isAuth) {
            this.getUserLogin()
            this.getNotifications()
        }
    }
});
