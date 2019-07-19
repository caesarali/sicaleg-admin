<template>
    <list-relawan v-if="query.village_id"></list-relawan>
    <list-dapil v-else></list-dapil>
</template>

<script>
import ListRelawan from "./ListRelawan";
import ListDapil from "./ListDapil";

export default {
    components: { ListDapil, ListRelawan },
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
