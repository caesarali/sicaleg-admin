<template>
    <tps-page v-if="query.village_id"></tps-page>
    <dpt-page v-else-if="query.tps_id"></dpt-page>
    <dapil-page v-else></dapil-page>
</template>


<script>
import DapilPage from "./DapilPage";
import TpsPage from "./TpsPage";
import DptPage from "./DptPage";
export default {
    components: {
        DapilPage, TpsPage, DptPage
    },

    computed: {
        query() {
            return this.$route.query
        }
    },

    watch: {
        '$route' (to, from) {
            this.init()
        }
    },

    methods: {
        init() {
            let params = this.$route.query
            if (Object.keys(params).length) {
                this.$root.back_button = true
            } else {
                this.$root.back_button = false
            }
        }
    },

    created() {
        this.init()
    }
}
</script>

<style lang="scss" scoped>
    .table thead th {
        vertical-align: middle !important;
    }
</style>

