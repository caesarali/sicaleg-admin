<template>
    <div class="wrapper">
        <app-header v-if="isAuth" :back-button="$root.back_button" />
        <app-sidebar v-if="isAuth" />

        <div :class="{ 'content-wrapper': isAuth }">
            <router-view></router-view>
        </div>

        <control-sidebar v-if="isAuth" />
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
            ...mapGetters(['isAuth'])
        },
        components: {
            'app-header': Header,
            'app-sidebar': Sidebar,
            'control-sidebar': ControlSidebar
        }
    }
</script>
