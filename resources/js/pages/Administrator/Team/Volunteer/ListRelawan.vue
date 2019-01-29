<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
                    </div>
                    <div class="col-auto">
                        <button-default :click="create" class="app-shadow">
                            <i class="fas fa-plus"></i>
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
                                Data Relawan
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="1%">#</th>
                                            <th>TPS</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>NIK</th>
                                            <th nowrap>No. HP</th>
                                            <th>Ket.</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in data" :key="item.id">
                                            <td>{{ index+1 }}.</td>
                                            <td nowrap>{{ item.tps }}</td>
                                            <td nowrap>{{ item.name }}</td>
                                            <td nowrap>{{ item.nik }}</td>
                                            <td nowrap>{{ item.address }}</td>
                                            <td nowrap>{{ item.phone }}</td>
                                            <td nowrap>{{ item.information }}</td>
                                            <td nowrap class="text-right">
                                                <a href="#" @click.prevent="edit(volunteers[index], index)" class="text-secondary mx-2">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a href="#" @click.prevent="destroy(index, item.id)" class="text-secondary ml-2">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <row-empty :colspan="7" v-if="!data.length"></row-empty>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="volunteerModal" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Relawan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update : store">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="tps">TPS <span class="text-danger">*</span></label>
                                        <select v-model="form.locationable_id" name="locationable_id" id="tps" class="form-control" :class="{ 'is-invalid': form.errors.has('tps') }">
                                            <option value="" hidden>Pilih:</option>
                                            <option v-for="item in tps" :key="item.id" :value="item.id">{{ item.name }}</option>
                                        </select>
                                        <has-error :form="form" field="tps"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama <span class="text-danger">*</span></label>
                                        <input v-model="form.name" id="name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" name="name" placeholder="Nama sesuai KTP..">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">No. Induk <span class="text-danger">*</span></label>
                                        <input v-model="form.nik" id="nik" type="text" maxlength="16" class="form-control" :class="{ 'is-invalid': form.errors.has('nik') }" name="nik" placeholder="Nomor Induk Kependudukan...">
                                        <has-error :form="form" field="nik"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">No. HP <span class="text-danger">*</span></label>
                                        <input v-model="form.phone" id="phone" type="text" maxlength="16" class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }" name="phone" placeholder="Nomor Handphone...">
                                        <has-error :form="form" field="phone"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Alamat <span class="text-danger">*</span></label>
                                        <input v-model="form.address" id="address" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('address') }" name="address" placeholder="Alamat relawan...">
                                        <has-error :form="form" field="address"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="information">Informasi Tambahan</label>
                                        <input v-model="form.information" id="information" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('information') }" name="information" placeholder="Keterangan (Optional)...">
                                        <has-error :form="form" field="information"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-light p-3">
                            <h5 class="modal-title">Akun Relawan</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">

                            </div>
                        </div>
                        <div class="modal-footer border-top-0 bg-light">
                            <button type="button" class="btn btn-secondary d-none d-sm-inline-block" data-dismiss="modal">Batal</button>
                            <button-default type="submit" :disabled="form.busy" class="btn-block-xs">
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
            editmode: false,
            volunteers: [],
            tps: [],
            form: new Form({
                index: '',
                id: '',
                name: '',
                nik: '',
                address: '',
                phone: '',
                information: '',
                locationable_id: '',
                username: '',
                email: '',
                password: ''
            })
        }
    },

    computed: {
        query() {
            return this.$route.query
        },
        data() {
            let data = this.volunteers.map(item => {
                return {
                    id: item.id,
                    tps: item.tps,
                    name: item.name,
                    nik: item.nik,
                    address: item.address,
                    phone: item.phone,
                    information: item.information
                }
            })
            return data.filter(item => {
                return item.name.toLowerCase().includes(this.$root.keywords.toLowerCase())
            });
        }
    },

    methods: {
        init() {
            axios.get('/volunteers', {
                params: this.query
            })
            .then(({ data }) => {
                this.volunteers = data.data
                this.tps = data.references
            })
        },
        modal(action) {
            $('#volunteerModal').modal(action)
        },

        create() {
            this.editmode = false
            this.form.reset()
            this.form.clear()
            this.modal('show')
        },
        store() {},
        edit(data, index) {
            this.editmode = true
            this.form.reset()
            this.form.clear()
            this.form.fill(data)
            this.form.index = index
            this.modal('show')
        },
        update() {},
        destroy() {},
    },

    created() {
        this.init();
    }
}
</script>
