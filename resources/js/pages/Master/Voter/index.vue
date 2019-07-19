<template>
    <tps-list v-if="query.village_id"></tps-list>
    <dpt-list v-else-if="params.tps_id"></dpt-list>
    <dapil-list v-else></dapil-list>
</template>


<script>
import DapilList from "./DapilList";
import TpsList from "./TpsList";
import DptList from "./DptList";
export default {
    components: {
        DapilList, TpsList, DptList
    },

    computed: {
        query() {
            return this.$route.query
        },
        params() {
            return this.$route.params
        }
    },

    watch: {
        '$route' (to, from) {
            this.init()
        }
    },

    methods: {
        init() {
            let params = this.params
            let query = this.query
            if (Object.keys(params).length && params.tps_id != undefined || Object.keys(query).length) {
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

