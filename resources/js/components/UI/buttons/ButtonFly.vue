<template>
    <button-default class="rounded-circle btn-fly app-shadow">
        <slot><i class="fas fa-plus"></i></slot>
    </button-default>
</template>

<script>
export default {
    name: 'ButtonFly'
}
</script>

<style>
    .btn-fly {
        position: fixed;
        bottom: 30px;
        right: 15px;
        height: 50px;
        width: 51px;
    }
</style>