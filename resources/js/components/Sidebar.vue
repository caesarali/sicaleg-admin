<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-x: hidden;">
        <a href="#" class="brand-link">
            <img src="/images/vote.png" alt="APP Logo" class="brand-image">
            <span class="brand-text"><b>SIM</b>CALEG</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/images/profile.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ name }}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link :to="{ name: 'dashboard' }" class="nav-link close-sidebar">
                            <i class="fas fa-home nav-icon"></i>
                            <p class="ml-1">Dashboard</p>
                        </router-link>
                    </li>

                    <li class="nav-header">Monitoring</li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'supporters' }" class="nav-link close-sidebar">
                            <i class="far fa-smile nav-icon"></i>
                            <p class="ml-1">Dukungan</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'monitoring' }" class="nav-link close-sidebar">
                            <i class="far fa-user-circle nav-icon"></i>
                            <p class="ml-1">Kinerja Relawan</p>
                        </router-link>
                    </li>


                    <li class="nav-header">CALEG</li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'candidate' }" class="nav-link close-sidebar">
                            <i class="fas fa-user-tie nav-icon"></i>
                            <p class="ml-1">PROFIL</p>
                        </router-link>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p class="ml-1">
                                TEAM <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{ name: 'team.coordinators' }" class="nav-link close-sidebar">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kordinator</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'team.volunteers' }" class="nav-link close-sidebar">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Relawan</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-header">SYSTEM</li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'master.dpt' }" class="nav-link close-sidebar">
                            <i class="fas fa-database nav-icon"></i>
                            <p class="ml-1">DPT</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'users' }" class="nav-link close-sidebar">
                            <i class="fas fa-database nav-icon"></i>
                            <p class="ml-1">AKUN</p>
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
export default {
    props: ['name', 'role']
}
</script>
