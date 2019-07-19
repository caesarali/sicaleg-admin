<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
                    </div>
                </div>
            </div>
        </div>
        <section class="content px-2">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-inline-block d-sm-none">
                                    <i class="fas fa-folder mr-1"></i> C1 Pileg
                                </div>
                                <div class="d-none d-sm-inline-block">
                                    <i class="fas fa-folder mr-1"></i>
                                    <template v-if="!location.kabupaten">
                                         C1 Peleg
                                    </template>
                                    <span v-if="location.kabupaten">
                                        <router-link :to="this.$route.path">
                                            C1 Peleg
                                        </router-link>
                                    </span>
                                    <span v-if="location.kabupaten">
                                        /
                                        <router-link disabled="disabled" :to="this.$route.path + '?city_id=' + this.queryId.substring(0,4)">
                                            {{ location.kabupaten }}
                                        </router-link>
                                    </span>
                                    <span v-if="location.kecamatan">
                                        /
                                        <router-link :to="this.$route.path + '?district_id=' + this.queryId.substring(0,7)">
                                            {{ location.kecamatan }}
                                        </router-link>
                                    </span>
                                    <span v-if="location.kelurahan">
                                        /
                                        <router-link :to="this.$route.fullPath">
                                            {{ location.kelurahan }}
                                        </router-link>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" width="1%">#</th>
                                            <th nowrap width="1%">Lokasi</th>
                                            <th nowrap class="text-center">Perolan Suara</th>
                                            <th nowrap>Foto C1</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in data" :key="item.id">
                                            <td class="text-center">{{ index+1 }}.</td>
                                            <td nowrap>
                                                <span v-if="lastLocation">{{ item.name }}</span>
                                                <router-link :to="item.path" v-else>
                                                    {{ item.name }}
                                                </router-link>
                                            </td>
                                            <td nowrap class="text-center">{{ item.quick_count }}</td>
                                            <td nowrap width="10%" class="py-1">
                                                <img src="/images/default-150x150.png" height="50px">
                                            </td>
                                        </tr>
                                        <row-empty :colspan="4" v-if="!data.length"></row-empty>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            c1: [],
            location: [],
        }
    },

    computed: {
        data() {
            let data = this.c1.map(item => {
                return {
                    name: item.name,
                    quick_count: item.quick_count,
                    path: this.$route.path + '?' + item.alias + '=' + item.id
                }
            })
            return data.filter(item => {
                return item.name.toLowerCase().includes(this.$root.keywords.toLowerCase())
            });
        },
        lastLocation() {
            if (!this.$route.query.village_id) {
                return false
            }
            return true
        },
        queryId() {
            var query = this.$route.query
            if (Object.keys(query).length) {
                return query[Object.keys(query)[0]];
            }
            return ''
        }
    },

    methods: {
        init() {
            this.c1 = []
            let params = this.$route.query
            axios.get('/election/c1', {
                params: params
            })
            .then(({ data }) => {
                this.c1 = data.data
                this.location = data.meta
            })
        },
        checkRoute() {
            let query = this.$route.query
            if (Object.keys(query).length) {
                this.$root.back_button = true
            } else {
                this.$root.back_button = false
            }
        }
    },

    watch: {
        '$route' (to, from) {
            this.init()
            this.checkRoute()
        }
    },

    created() {
        this.init()
        this.checkRoute()
    },
}
</script>

<style lang="scss" scoped>
    a.exactActive {
        font-weight: bold;
    }
</style>

