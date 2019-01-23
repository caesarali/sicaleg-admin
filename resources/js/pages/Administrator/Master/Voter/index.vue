<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="form-inline">
                            <div class="input-group app-shadow">
                                <input type="search" placeholder="Search" aria-label="Search" class="form-control form-control-navbar border-0">
                                <div class="input-group-append">
                                    <div class="input-group-text bg-white border-0">
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto d-none d-md-inline-block">
                        <button-default type="button" :click="$root.goBack()">
                            Back
                        </button-default>
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
                                            <th class="text-center" width="1%">#</th>
                                            <th>Wilayah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in locations" :key="item.id">
                                            <td class="text-center">{{ index+1 }}.</td>
                                            <td>
                                                <router-link :to="'/admin/master/dpt/list?'+item.alias+'='+item.id">
                                                    {{ item.name }}
                                                </router-link>
                                            </td>
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

    watch: {
        '$route' (to, from) {
            this.init()
        }
    },

    created() {
        this.init()
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
    }
}
</script>
