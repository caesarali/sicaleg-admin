<template>
    <div class="text-center">
        <pulse-loader :loading="loading" :color="color" :size="size"></pulse-loader>
    </div>
</template>

<script>
export default {
    // components: {
    //     'ring-loader': require('vue-spinner/src/RingLoader.vue'),
    //     'pulse-loader': require('vue-spinner/src/PulseLoader.vue')
    // },
    props: ['loading'],
    data() {
        return {
            color: '#d2d6de',
            size: '10px'
        }
    }
}
</script>
