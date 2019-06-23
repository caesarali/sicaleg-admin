import Vue from 'vue'
import Router  from 'vue-router'

// Page Components
import Web from '../pages/Web';
import Home from '../pages/Web/Home';

import Administrator from "../pages/Administrator";
import Dashboard from "../pages/Administrator/Dashboard";
import Candidate from "../pages/Administrator/Candidate";
import Party from "../pages/Administrator/Party";

import Master from "../pages/Administrator/Master";
import Voter from "../pages/Administrator/Master/Voter";

import Team from "../pages/Administrator/Team";
import Coordinator from "../pages/Administrator/Team/Coordinator";
import Volunteer from "../pages/Administrator/Team/Volunteer";

import C1 from "../pages/Administrator/Election/C1";

import User from "../pages/Administrator/Auth/User";

// Error Page Components
import PageNotFound from "../pages/Errors/404";

const router = new Router({
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "exactActive",
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
                { path: 'dashboard', name: 'admin.dashboard', component: Dashboard },
                { path: 'candidate', name: 'admin.candidate', component: Candidate },
                { path: 'party', name: 'admin.party', component: Party },
                { path: 'master', component: Master,
                    children: [
                        { path: 'dpt/list/:tps_id?', name: 'master.dpt', component: Voter },
                        { path: 'dpt/list/:tps_id/import', name: 'master.dpt.import', component: Voter },
                    ]
                },
                { path: 'team', component: Team,
                    children: [
                        { path: 'coordinators', name: 'team.coordinators', component: Coordinator },
                        { path: 'volunteers', name: 'team.volunteers', component: Volunteer },
                    ]
                },
                { path: 'election/c1', name: 'admin.election.c1', component: C1 },
                { path: 'users', name: 'users', component: User }
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
