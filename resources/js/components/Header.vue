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

        <a href="#" class="brand-link mx-auto py-0 my-0 d-inline-block d-sm-none h3 font-weight-bold">
            SICALEG
        </a>

        <ul class="navbar-nav ml-sm-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
// export default {
//     props: {
//         backButton: {
//             default: false
//         }
//     }
// }
</script>
