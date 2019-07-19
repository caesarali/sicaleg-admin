import Vue from 'vue'
import Router  from 'vue-router'
import store from '../stores'

// Auth Page Components
import Login from '../pages/Auth/Login';
// Page Components
import Dashboard from "../pages/Dashboard";
import Candidate from "../pages/Candidate";
import Team from "../pages/Team";
import Supporter from "../pages/Supporter";
import Supporters from "../pages/Supporter/Supporters";
import SupportersByGender from "../pages/Supporter/SupportersByGender";
import SupportersByAge from "../pages/Supporter/SupportersByAge";
import Coordinator from "../pages/Team/Coordinator";
import Volunteer from "../pages/Team/Volunteer";
import Master from "../pages/Master";
import Voter from "../pages/Master/Voter";
import User from "../pages/Auth/User";
// Error Page Components
import PageNotFound from "../pages/Errors/404";

Vue.use(Router)

const router = new Router({
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "exactActive",
    scrollBehavior (to, from) {
        return { x: 0, y: 0 }
    },
    routes: [
        // Login Page
        { path: '/login', name: 'login', component: Login },

        { path: '/home', redirect: 'dashboard'},
        { path: '/dashboard', name: 'dashboard', component: Dashboard },
        { path: '/candidate', name: 'candidate', component: Candidate },
        { path: '/supporters', component: Supporter,
            children: [
                { path: '', name: 'supporters', component: Supporters },
                { path: 'by-gender', name: 'supporters.byGender', component: SupportersByGender },
                { path: 'by-age', name: 'supporters.byAge', component: SupportersByAge }
            ]
        },

        { path: '/team', component: Team,
            children: [
                { path: 'coordinators', name: 'team.coordinators', component: Coordinator },
                { path: 'volunteers', name: 'team.volunteers', component: Volunteer },
            ]
        },

        { path: '/master', component: Master,
            children: [
                { path: 'dpt/list/:tps_id?', name: 'master.dpt', component: Voter },
                { path: 'dpt/list/:tps_id/import', name: 'master.dpt.import', component: Voter },
            ]
        },

        { path: '/users', name: 'users', component: User },

        // // Error Page
        { path: '*', name: '404', component: PageNotFound },
    ]
})

//Navigation Guards
// router.beforeEach((to, from, next) => {
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//         let auth = store.getters.isAuth
//         if (!auth) {
//             next({ name: 'login' })
//         } else {
//             next()
//         }
//     } else {
//         next()
//     }
// })

// router.beforeResolve((to, from, next) => {
//     if ($('.modal').hasClass('show')) {
//         $('.modal').modal('hide');
//     } else {
//         $('body').removeClass('control-sidebar-slide-open');
//         if (to.name) {
//             // router.app.$Progress.start()
//         }
//         next()
//     }
// })

export default router;
