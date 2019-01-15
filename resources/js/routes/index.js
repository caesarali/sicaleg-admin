import Vue from 'vue'
import Router  from 'vue-router'

// Page Components
import Web from '../pages/Web';
import Home from '../pages/Web/Home';

import Administrator from "../pages/Administrator";
import Dashboard from "../pages/Administrator/Dashboard";
import Candidate from "../pages/Administrator/Candidate";
import Coordinator from "../pages/Administrator/Coordinator";

// Error Page Components
import PageNotFound from "../pages/Errors/404";

const router = new Router({
    mode: 'history',
    // linkActiveClass: "active",
    linkExactActiveClass: "active",
    scrollBehavior (to, from) {
        return { x: 0, y: 0 }
    },
    routes: [
        // User Page
        { path: '/', component: Web,
            children: [
                { path: '', redirect: 'home' },
                { path: 'home', name: 'home', component: Home },
            ]
        },

        // Administrator Page
        { path: '/admin', component: Administrator,
            children: [
                { path: '', redirect: 'dashboard'},
                { path: 'dashboard', name: 'admin.dashboard', component: Dashboard},
                { path: 'candidate', name: 'admin.candidate', component: Candidate},
                { path: 'coordinators', name: 'admin.coordinators', component: Coordinator},
            ]
        },


        // Error Page
        { path: '*', name: '404', component: PageNotFound },
    ]
})

router.beforeResolve((to, from, next) => {
    if ($('.modal').hasClass('show')) {
        $('.modal').modal('hide');
    } else {
        $('body').removeClass('control-sidebar-slide-open');
        if (to.name) {
            // router.app.$Progress.start()
        }
        next()
    }
})


Vue.use(Router)

export default router;