<template>
    <router-view v-if="$role.isAdmin()"></router-view>
    <not-found v-else />
</template>

<script>
import NotFound from '../Errors/404';

export default {
    components: { NotFound }
}
</script>