<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <div class="row mb-3">
                <div class="col">
                    <search-box></search-box>
                </div>
                <div class="col-auto">
                    <router-link :to="{ name: 'supporters.byGender' }" class="btn bg-white app-shadow mr-sm-2">
                        <i class="fas fa-chart-bar"></i> Jenis Kelamin
                    </router-link>
                    <router-link :to="{ name: 'supporters.byAge' }" class="btn bg-white app-shadow">
                        <i class="fas fa-chart-bar"></i> Usia
                    </router-link>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Daftar Pendukung
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table" nowrap>
                                <thead class="thead-light">
                                    <tr>
                                        <th width="1%">#</th>
                                        <th width="1%">NIK</th>
                                        <th>Nama</th>
                                        <th>Usia</th>
                                        <th>Gender</th>
                                        <th>Kec.</th>
                                        <th>Kel./Desa</th>
                                        <th>Oleh</th>
                                        <th class="text-center">Waktu</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in supporters.data" :key="item.id">
                                        <td>{{ supporters.meta.from + index }}.</td>
                                        <td>{{ item.voter.nik }}</td>
                                        <td nowrap>{{ item.voter.name }}</td>
                                        <td nowrap>{{ item.voter.age }} Tahun</td>
                                        <td nowrap class="text-uppercase">{{ item.voter.gender | gender }}</td>
                                        <td nowrap>{{ item.voter.tps.village.district.name }}</td>
                                        <td nowrap>{{ item.voter.tps.village.name }}</td>
                                        <td nowrap>{{ item.created_by.name }}</td>
                                        <td nowrap class="text-center">{{ item.created_at }}</td>
                                        <td nowrap class="text-right">
                                            <a href="#" @click.prevent="removeSupporter(index, item.id)" class="text-secondary ml-2">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <row-empty :colspan="10" v-if="!supporters.data.length"></row-empty>
                                </tbody>
                            </table>
                        </div>
                        <div class="overlay d-flex justify-content-center" v-if="$root.isLoading" style="align-items: center;">
                            <i class="fas fa-2x fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    <paginate v-if="supporters.data.length"
                        v-model="supporters.meta.current_page"
                        :page-count="supporters.meta.last_page"
                        :click-handler="getSupporters"
                        :prev-text="'Prev'"
                        :next-text="'Next'"
                        :container-class="'pagination justify-content-center'"
                        :page-class="'page-item'"
                        :page-link-class="'page-link'"
                        :prev-class="'page-item'"
                        :prev-link-class="'page-link'"
                        :next-class="'page-item'"
                        :next-link-class="'page-link'"
                    >
                    </paginate>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            supporters: {
                data: []
            }
        }
    },
    watch: {
        '$root.keywords'(value) {
            this.$root.isSearching = true
            this.search()
        }
    },
    methods: {
        search: _.debounce(function() {
            this.getSupporters()
        }, 300),
        getSupporters(page = 1) {
            axios.get('/supporters', {
                params: {
                    page: page,
                    keyword: this.$root.keywords
                }
            })
            .then(({ data }) => this.supporters = data)
            .catch()
            .then(() => {
                this.$root.isSearching = false
                this.$root.isLoading = false
            })
        },
        removeSupporter(index, id) {
            this.$confirm.delete().then((result) => {
                if (result.value) {
                    axios.delete('/supporters/' + id)
                    .then(({ data }) => {
                        this.supporters.data.splice(index, 1);
                        toast({ type: 'success', title: data.message })
                    })
                    .catch(() => {
                        toast({ type: 'error', title: 'Terjadi Kesalahan!' });
                    });
                }
            })
        }
    },
    mounted() {
        this.getSupporters();
        this.$root.back_button = false;
    }
}
</script>
