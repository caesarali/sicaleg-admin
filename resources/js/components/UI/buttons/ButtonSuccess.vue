<template>
    <button class="btn btn-success" @click="click">
        <slot>Button Default</slot>
    </button>
</template>

<script>
export default {
    props: {
        click: {
            required: false,
            type: Function,
            default: function() {
                console.log('Button is Clicked.')
            }
        }
    }
}
</script>
