<template>
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" v-if="!$root.back_button">
                    <i class="fas fa-bars"></i>
                </a>
                <a class="nav-link" href="#" v-on:click="$router.go(-1)" v-else>
                    <i class="fas fa-arrow-left"></i> <span class="ml-1 d-none d-sm-inline font-weight-bold">Back</span>
                </a>
            </li>
        </ul>

        <a href="#" class="brand-link mr-auto py-0 my-0 d-inline-block d-sm-none h3 font-weight-bold">
            SIMCALEG
        </a>

        <ul class="navbar-nav ml-sm-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" @click="$root.markAsReadNotification()">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-danger navbar-badge" v-if="notifications.length">{{ notifications.length }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">
                        <span v-text="notifications.length > 0 ? notifications.length : 'Tidak ada' "></span> Pemberitahuan
                    </span>
                    <div class="dropdown-divider"></div>
                    <div style="cursor: pointer" class="dropdown-item" v-for="item in notifications.slice(0, 5)" :key="item.id">
                        <div class="media">
                            <!-- <img src="/images/profile.png" alt="User Avatar" class="img-size-50 mr-3 img-circle"> -->
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{ item.data.user_name }}
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Menambahkan 1 pendukung baru</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>
                                    {{ item.created_at }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider" v-if="notifications.length"></div>
                    <div style="cursor: pointer" class="dropdown-item dropdown-footer" v-if="notifications.length" @click="showAll">
                        Lihat Semua
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    computed: {
        notifications() {
            return this.$root.notifications
        }
    },
    methods: {
        showAll() {
            return this.$router.push({ name: 'monitoring' })
        }
    }
}
</script>

