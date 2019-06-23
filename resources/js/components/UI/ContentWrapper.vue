<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
                    </div>
                    <slot name="action"></slot>
                </div>
            </div>
        </div>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'content-wrapper'
}
</script>
