<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
                    </div>
                    <div class="col-auto">
                        <button-default :click="create">
                            Create
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
                                            <th class="text-center" width="1%">No.</th>
                                            <th>TPS</th>
                                            <th class="text-center" colspan="3">Jumlah Pemilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in data" :key="item.id">
                                            <td class="text-center">{{ index+1 }}.</td>
                                            <td>
                                                <router-link :to="item.path">
                                                    TPS {{ item.name }}
                                                </router-link>
                                            </td>
                                            <td class="text-center" width="10%">L: 0</td>
                                            <td class="text-center" width="10%">P: 0</td>
                                            <td class="text-center" width="10%">Total: 0</td>
                                            <td class="text-right">
                                            <a href="#" @click.prevent="destroy(index, item.id)" class="text-secondary ml-2">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
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

        <div id="tpsModal" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">TPS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="store">
                        <div class="modal-body">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">TPS</span>
                                </div>
                                <input v-model="form.name" id="name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" name="name" placeholder="Input nomor TPS.." autofocus>
                                <has-error :form="form" field="name"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 bg-light">
                            <button type="button" class="btn btn-secondary btn-sm d-none d-sm-inline-block" data-dismiss="modal">Batal</button>
                            <button-default type="submit" :disabled="form.busy" class="btn-sm btn-block-xs">
                                <i class="fas fa-check mr-1"></i> Tambahkan
                            </button-default>
                        </div>
                    </form>
                </div>
                <div class="text-center m-1 d-block d-sm-none" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-angle-double-up"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tps: [],
            form: new Form({
                name: '',
                village_id: this.$route.query.village_id
            })
        }
    },

    computed: {
        data() {
            let data = this.tps.map(item => {
                return {
                    id: item.id,
                    name: item.name,
                    path: this.$route.path + '?' + item.alias + '=' + item.id,
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
                this.tps = data.data
            })
        },

        create() {
            this.form.reset();
            this.form.clear();
            this.modal('show');
        },

        store() {
            this.form.post('/tps')
            .then(({ data }) => {
                this.tps.push(data.data)
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(() => {})
        },

        destroy(index, id) {
            this.$confirm.delete().then((result) => {
                if (result.value) {
                    this.form.delete('/tps/' + id)
                    .then(({ data }) => {
                        this.tps.splice(index, 1);
                        toast({ type: 'success', title: data.message })
                    })
                    .catch(() => {
                        toast({ type: 'error', title: 'Terjadi Kesalahan!' });
                    });
                }
            })
        },

        modal(action) {
            $('#tpsModal').modal(action)
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
