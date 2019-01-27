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
                                <table class="table table-hover nowrap">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" width="1%">#</th>
                                            <th>Lokasi</th>
                                            <th nowrap class="text-center">Jumlah TPS</th>
                                            <th nowrap class="text-center" colspan="3">Jumlah Pemilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in data" :key="item.id">
                                            <td class="text-center">{{ index+1 }}.</td>
                                            <td nowrap>
                                                <router-link :to="item.path">
                                                    {{ item.name }}
                                                </router-link>
                                            </td>
                                            <td nowrap class="text-center">{{ item.tps }}</td>
                                            <td nowrap class="text-center" width="10%">L: {{ item.male }}</td>
                                            <td nowrap class="text-center" width="10%">P: {{ item.female }}</td>
                                            <td nowrap class="text-center" width="10%">Total: {{ item.total }}</td>
                                        </tr>
                                        <row-empty :colspan="6" v-if="!data.length"></row-empty>
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
        data() {
            let data = this.locations.map(item => {
                return {
                    name: item.name,
                    tps: item.tps,
                    male: item.male,
                    female: item.female,
                    total: item.male + item.female,
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
            axios.get('/dpt', {
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
