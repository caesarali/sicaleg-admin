<template>
    <aside class="control-sidebar control-sidebar-light">
        <div class="p-3">
            <img src="/images/profile.png" class="img-fluid mx-auto d-block rounded-circle" style="width: 75px">
            <div class="pt-2 text-center">
                <h5 class="mb-0">{{ name }}</h5>
                <p class="text-uppercase">{{ role }}</p>
            </div>
            <hr class="mt-0">
            <button class="btn btn-outline-secondary btn-block" @click="postLogout">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </div>
    </aside>
</template>



<script>
import { mapActions } from 'vuex';
export default {
    props: ['name', 'role'],
    methods: {
        ...mapActions('auth', ['logout']),
        postLogout() {
            this.toggleControlSidebar();
            this.logout()
            this.$router.push({ name: 'login' })
        },

        toggleControlSidebar() {
            $('body').removeClass('control-sidebar-slide-open');
        }
    }
}
</script>

