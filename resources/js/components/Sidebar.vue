<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-x: hidden;">
        <a href="#" class="brand-link">
            <img src="/images/logo-m-90x90.png" alt="APP Logo" class="brand-image img-circle">
            <span class="brand-text font-weight-bold">SICALEG</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/images/profile.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Caesar Ali L.</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <router-link :to="{ name: 'admin.dashboard' }" class="nav-link close-sidebar">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <p class="ml-1">Dashboard</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'home' }" class="nav-link close-sidebar">
                            <i class="fas fa-home nav-icon"></i>
                            <p>Home</p>
                        </router-link>
                    </li>
                    <li class="nav-header">CALEG</li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'admin.candidate' }" class="nav-link close-sidebar">
                            <i class="fas fa-user-tie nav-icon"></i>
                            <p class="ml-1">PROFIL</p>
                        </router-link>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p class="ml-1">
                                TEAM
                                <i class="fa fa-angle-left right"></i>
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
