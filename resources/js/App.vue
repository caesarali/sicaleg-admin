<template>
    <div class="wrapper">
        <app-header v-if="isAuth" />
        <app-sidebar v-if="isAuth" :name="name" :role="role"/>

        <div :class="{ 'content-wrapper': isAuth }">
            <router-view></router-view>
        </div>

        <control-sidebar v-if="isAuth" :name="name" :role="role" />
    </div>
</template>
<script>
    import { mapState, mapGetters } from 'vuex'
    import Header from './components/Header'
    import Sidebar from './components/Sidebar'
    import ControlSidebar from './components/ControlSidebar'
    export default {
        computed: {
            ...mapState(['token']),
            ...mapGetters(['isAuth']),
            name() {
                return localStorage.getItem('name')
            },
            role() {
                return localStorage.getItem('role')
            }
        },
        components: {
            'app-header': Header,
            'app-sidebar': Sidebar,
            'control-sidebar': ControlSidebar
        }
    }
</script>
