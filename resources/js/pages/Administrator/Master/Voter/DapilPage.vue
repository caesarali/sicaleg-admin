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
                                Daftar Pemilih Tetap
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="1%">No.</th>
                                            <th>Lokasi</th>
                                            <th class="text-center">Jumlah TPS</th>
                                            <th class="text-center" colspan="3">Jumlah Pemilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in dapil" :key="item.id">
                                            <td class="text-center">{{ index+1 }}.</td>
                                            <td>
                                                <router-link :to="item.path">
                                                    {{ item.name }}
                                                </router-link>
                                            </td>
                                            <td class="text-center">{{ item.tps }}</td>
                                            <td class="text-center">L: 0</td>
                                            <td class="text-center">P: 0</td>
                                            <td class="text-center">T: 0</td>
                                        </tr>
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
            locations: []
        }
    },

    computed: {
        dapil() {
            let data = this.locations.map(item => {
                return {
                    name: item.name,
                    tps: item.tpsCount,
                    path: this.$route.path + '?' + item.alias + '=' + item.id
                }
            })
            return data.filter(item => {
                return item.name.toLowerCase().includes(this.$root.keywords.toLowerCase())
            });
        }
    },

    methods: {
        init() {
            let params = this.$route.query
            axios.get('/dpt/list', {
                params: params
            })
            .then(({ data }) => {
                this.locations = data.data
            })
        }
    },

    watch: {
        '$route' (to, from) {
            this.init()
        }
    },

    created() {
        this.init()
    }
}
</script>
