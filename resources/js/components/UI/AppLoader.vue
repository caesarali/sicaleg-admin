<template>
    <div class="text-center">
        <pulse-loader v-if="loader == 'pulse'" :loading="loading" :color="color"></pulse-loader>
        <moon-loader v-if="loader == 'moon'" :loading="loading" :color="color" class="d-inline-block" ></moon-loader>
    </div>
</template>

<script>
export default {
    props: {
        loading: { type: Boolean, required: false, default: false },
        loader: { type: String, required: false, default: 'pulse' },
        color: { type: String, required: false, default: '#007bff' },
        // size: { type: String, required: false,  default: '40px' }
    },
}
</script>
