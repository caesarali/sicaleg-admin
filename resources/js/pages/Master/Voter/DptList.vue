<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success app-shadow d-none d-md-inline" @click="$refs.importModal.show()">
                            <i class="fas fa-file-import"></i>
                            <span class="d-none d-md-inline ml-1"> Import</span>
                        </button>
                        <button-default class="app-shadow" :click="create">
                            <i class="fas fa-user-plus"></i>
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
                                <!-- <div class="row d-none d-md-flex">
                                    <div class="col-md">
                                        <div class="row">
                                            <label class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-plaintext"><span class="d-none d-sm-inline">: </span>{{ meta.provinsi }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3 col-form-label">Kab. / Kota</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-plaintext"><span class="d-none d-sm-inline">: </span>{{ meta.kabupaten }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-3 col-form-label">Kecamatan</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-plaintext"><span class="d-none d-sm-inline">: </span>{{ meta.kecamatan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="row d-flex justify-content-end">
                                            <label class="col-sm-4 col-form-label">Desa/Keluarahan</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-plaintext"><span class="d-none d-sm-inline">: </span>{{ meta.kelurahan }}</p>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-end">
                                            <label class="col-sm-4 col-form-label">TPS</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-plaintext"><span class="d-none d-sm-inline">: </span>{{ meta.tps }}</p>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-end">
                                            <label class="col-sm-4 col-form-label">Jumlah Pemilih</label>
                                            <div class="col-sm-4">
                                                <p class="form-control-plaintext">
                                                    <span class="d-none d-sm-inline">: </span>
                                                    <badge-default>{{ meta.total }}</badge-default>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="1%">#</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th nowrap>Tempat, Tgl Lahir</th>
                                            <th nowrap>Jenis Kelamin</th>
                                            <th class="text-center">TPS</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in data" :key="item.id">
                                            <td>{{ meta.from + index }}.</td>
                                            <td nowrap @click.prevent="show(dpt[index])" style="cursor: pointer" class="text-primary">{{ item.nik }}</td>
                                            <td nowrap>{{ item.name }}</td>
                                            <td nowrap>{{ item.birth_place }}, {{ item.birth_date }}</td>
                                            <td nowrap>{{ item.gender | gender }}</td>
                                            <td nowrap class="text-center">TPS {{ item.tps }}</td>
                                            <td nowrap class="text-right">
                                                <a href="#" @click.prevent="show(dpt[index])" class="text-secondary mx-2">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="#" @click.prevent="edit(index, dpt[index])" class="text-secondary mx-2">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a href="#" @click.prevent="destroy(index, item.id)" class="text-secondary ml-2">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <row-empty :colspan="8" v-if="!data.length"></row-empty>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <paginate v-if="data.length"
                            v-model="meta.current_page"
                            :page-count="meta.last_page"
                            :click-handler="init"
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
        </section>

        <div class="modal fade" id="dptModal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Pemilih</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : store()">
                        <div class="modal-body p-0">
                            <div class="p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kk">No. KK <span class="text-danger">*</span></label>
                                            <input v-model="form.kk" id="kk" type="text" maxlength="16" class="form-control" :class="{ 'is-invalid': form.errors.has('kk') }" name="kk" placeholder="Nomor Kartu Keluarga...">
                                            <has-error :form="form" field="kk"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="nik">NIK <span class="text-danger">*</span></label>
                                            <input v-model="form.nik" id="nik" type="text" maxlength="16" class="form-control" :class="{ 'is-invalid': form.errors.has('nik') }" name="nik" placeholder="Nomor Induk Kependudukan...">
                                            <has-error :form="form" field="nik"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nama <span class="text-danger">*</span></label>
                                            <input v-model="form.name" id="name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" name="name" placeholder="Nama sesuai KTP..">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label for="birth_place">Tempat Lahir <span class="text-danger">*</span></label>
                                                    <input v-model="form.birth_place" id="birth_place" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('birth_place') }" name="birth_place" placeholder="Tempat Kelahiran..">
                                                    <has-error :form="form" field="birth_place"></has-error>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="birth_date">Tgl. Lahir <span class="text-danger">*</span></label>
                                                    <input v-model="form.birth_date" id="birth_date" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('birth_date') }" name="birth_date" placeholder="Tanggal Lahir..">
                                                    <has-error :form="form" field="birth_date"></has-error>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="marital_status">Status Pernikahan <span class="text-danger">*</span></label>
                                            <select name="marital_status" v-model="form.marital_status" id="marital_status" class="form-control" :class="{ 'is-invalid': form.errors.has('marital_status') }">
                                                <option value="b">Belum Menikah</option>
                                                <option value="s">Sudah Menikah</option>
                                                <option value="p">Pernah Menikah</option>
                                            </select>
                                            <has-error :form="form" field="marital_status"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <select name="gender" v-model="form.gender" id="gender" class="form-control" :class="{ 'is-invalid': form.errors.has('gender') }">
                                                <option value="l">Laki-laki</option>
                                                <option value="p">Perempuan</option>
                                            </select>
                                            <has-error :form="form" field="gender"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="disability_id">Disabilitas</label>
                                            <select name="disability_id" v-model="form.disability_id" id="disability_id" class="form-control" :class="{ 'is-invalid': form.errors.has('disability_id') }">
                                                <option :value="editmode ? null : ''">Normal</option>
                                                <option v-for="disability in disabilities" :key="disability.id" :value="disability.id">{{ disability.name }}</option>
                                            </select>
                                            <has-error :form="form" field="disability_id"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="information">Keterangan</label>
                                            <input v-model="form.information" id="information" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('information') }" name="information" placeholder="Keterangan (Optional)...">
                                            <has-error :form="form" field="information"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-light border-0">
                                <h5 class="modal-title">Informasi Alamat</h5>
                            </div>
                            <div class="p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="addr_street">Jalan / Dusun</label>
                                            <input v-model="form.addr_street" id="addr_street" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('addr_street') }" name="addr_street" placeholder="* Jalan / Dusun..">
                                            <has-error :form="form" field="addr_street"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            <label for="addr_rt">RT</label>
                                            <input v-model="form.addr_rt" id="addr_rt" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('addr_rt') }" name="addr_rt" placeholder="* RT..">
                                            <has-error :form="form" field="addr_rt"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <div class="form-group">
                                            <label for="addr_rw">RW</label>
                                            <input v-model="form.addr_rw" id="addr_rw" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('addr_rw') }" name="addr_rw" placeholder="* RW..">
                                            <has-error :form="form" field="addr_rw"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 bg-light">
                            <button type="button" class="btn btn-secondary d-none d-sm-inline-block" data-dismiss="modal">Batal</button>
                            <button-default type="submit" :disabled="form.busy" class="btn-block-xs">
                                <i class="fas fa-check mr-1"></i> Simpan
                            </button-default>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showModal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title">Profil Pemilih</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0 table-responsive">
                        <table class="table table-hover nowrap">
                            <tbody>
                                <tr>
                                    <th class="d-flex">No. KK <span class="ml-auto">:</span></th>
                                    <td>{{ form.kk }}</td>
                                </tr>
                                <tr>
                                    <th class="d-flex">No. Induk <span class="ml-auto">:</span></th>
                                    <td>{{ form.nik }}</td>
                                </tr>
                                <tr>
                                    <th class="d-flex">Nama <span class="ml-auto">:</span></th>
                                    <td>{{ form.name }}</td>
                                </tr>
                                <tr>
                                    <th class="d-flex">Tempat, Tgl. Lahir <span class="ml-auto">:</span></th>
                                    <td>{{ form.birth_place }}, {{ form.birth_date }}</td>
                                </tr>
                                <tr>
                                    <th class="d-flex">Status Pernikahan <span class="ml-auto">:</span></th>
                                    <td>{{ form.marital_status | marital }}</td>
                                </tr>
                                <tr>
                                    <th class="d-flex">Jenis Kelamin <span class="ml-auto">:</span></th>
                                    <td>{{ form.gender | gender }}</td>
                                </tr>
                                <tr>
                                    <th class="d-flex">Alamat <span class="ml-auto">:</span></th>
                                    <td>{{ form.addr_street}}, <br>
                                        RT-{{ form.addr_rt }}, RW-{{ form.addr_rw }}.
                                    </td>
                                </tr>
                                <tr>
                                    <th class="d-flex">Disabilitas <span class="ml-auto">:</span></th>
                                    <td>{{ form.disability_id ? form.disability_id : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center m-1 d-block d-sm-none" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-angle-double-up"></i>
                </div>
            </div>
        </div>

        <dpt-import ref="importModal"></dpt-import>
    </div>
</template>

<script>
import DptImport from "./DptImport";
export default {
    components: {
        DptImport
    },
    data() {
        return {
            editmode: false,
            dpt: [],
            disabilities: [],
            form: new Form({
                index: '',
                id: '',
                tps_id: this.$route.params.tps_id,
                kk: '',
                nik: '',
                name: '',
                birth_place: '',
                birth_date: '',
                marital_status: 'b',
                gender: 'l',
                addr_street: '',
                addr_rt: '',
                addr_rw: '',
                disability_id: '',
                information: ''
            }),
            meta: {},
            links: {}
        }
    },

    watch: {
        '$root.keywords'(value) {
            this.$root.isSearching = true
            this.search()
        }
    },

    computed: {
        data() {
            return this.dpt.map(item => {
                return {
                    id: item.id,
                    tps: item.tps,
                    name: item.name,
                    nik: item.nik,
                    birth_place: item.birth_place,
                    birth_date: item.birth_date,
                    gender: item.gender
                }
            })
        },
        pagination() {
            return {
                data: this.data,
                links: this.links,
                meta: this.meta
            }
        },
    },

    methods: {
        init(page = 1) {
            let params = this.$route.params
            axios.get('/dpt', {
                params: {
                    tps_id: params.tps_id,
                    page: page,
                    keyword: this.$root.keywords
                }
            })
            .then(({ data }) => {
                this.dpt = data.data
                this.meta = data.meta
                this.links = data.links
                this.disabilities = data.ref_disabilities
            })
            .catch()
            .then(() => this.$root.isSearching = false)
        },
        search: _.debounce(function() {
            this.init()
        }, 300),
        create() {
            this.editmode = false
            this.form.reset()
            this.form.clear()
            $('#dptModal').modal('show')
        },
        store() {
            this.form.post('/dpt')
            .then(({ data }) => {
                this.dpt.push(data.data)
                $('#dptModal').modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(() => {})
        },
        show(data) {
            this.form.reset()
            this.form.clear()
            this.form.fill(data)
            $('#showModal').modal('show')
        },
        edit(index, data) {
            this.editmode = true
            this.form.reset()
            this.form.clear()
            this.form.fill(data)
            this.form.index = index
            $('#dptModal').modal('show')
        },
        update() {
            this.form.patch('/dpt/' + this.form.id)
            .then(({ data }) => {
                this.dpt.splice(this.form.index, 1, data.data);
                $('#dptModal').modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(() => {})
        },
        destroy(index, id) {
            this.$confirm.delete().then((result) => {
                if (result.value) {
                    this.form.delete('/dpt/' + id)
                    .then(({ data }) => {
                        this.dpt.splice(index, 1);
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
        this.init()
    }
}
</script>
