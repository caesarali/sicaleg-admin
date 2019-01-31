<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
                    </div>
                    <div class="col-auto">
                        <button-default :click="create" class="app-shadow rounded-circle">
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
                                Daftar Relawan
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="1%">#</th>
                                            <th>Nama</th>
                                            <th nowrap>No. HP</th>
                                            <th nowrap>Tugas / Peran</th>
                                            <th class="text-center">Wilayah</th>
                                            <th class="text-center">Kontribusi</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in data" :key="item.id">
                                            <td>{{ index+1 }}.</td>
                                            <td nowrap>
                                                <a href="#" @click.prevent="edit(coordinators[index], index)">
                                                    {{ item.name }}
                                                </a>
                                            </td>
                                            <td nowrap>{{ item.phone }}</td>
                                            <td nowrap>{{ item.role.name }}</td>
                                            <td nowrap class="text-center">{{ item.location }}</td>
                                            <td nowrap class="text-center">0 Suara</td>
                                            <td nowrap class="text-right">
                                                <a href="#" @click.prevent="edit(coordinators[index], index)" class="text-secondary mx-2">
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

        <div id="coordinatorModal" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Data Kordinator</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : store()">
                        <div class="modal-body p-0">
                            <div class="p-3">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="form-group">
                                            <label for="role">Tugas / Peran <span class="text-danger">*</span></label>
                                            <select v-model="form.role" name="role" id="tps" class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                                <option value="" hidden>Pilih:</option>
                                                <option :value="item.code" v-for="item in roles" :key="item.id">{{ item.name }}</option>
                                            </select>
                                            <has-error :form="form" field="role"></has-error>
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
                                    <div class="col-md">
                                        <div class="form-group">
                                            <label for="address">Alamat <span class="text-danger">*</span></label>
                                            <input v-model="form.address" id="address" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('address') }" name="address" placeholder="Alamat relawan...">
                                            <has-error :form="form" field="address"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">No. HP <span class="text-danger">*</span></label>
                                            <input v-model="form.phone" id="phone" type="text" maxlength="16" class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }" name="phone" placeholder="Nomor Handphone...">
                                            <has-error :form="form" field="phone"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="information">Informasi Tambahan</label>
                                            <input v-model="form.information" id="information" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('information') }" name="information" placeholder="Keterangan (Optional)...">
                                            <has-error :form="form" field="information"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <template v-if="form.role">
                                <div class="bg-light p-3">
                                    <h5 class="modal-title">Lokasi</h5>
                                </div>
                                <div class="p-3">
                                    <div class="row">
                                        <div class="col-md" v-if="$root.env_level == 'dpr'">
                                            <div class="form-group">
                                                <label for="city_id">Kabupaten / Kota <span class="text-danger">*</span></label>
                                                <select v-model="form.city_id" name="city_id" id="tps" class="form-control" :class="{ 'is-invalid': form.errors.has('city_id') }">
                                                    <option value="" hidden>Pilih:</option>
                                                    <option v-for="item in locations.cities" :key="item.id" :value="item.id">{{ item.name }}</option>
                                                </select>
                                                <has-error :form="form" field="city_id"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md" v-if="form.role == 'district-co' || form.role == 'village-co'">
                                            <div class="form-group">
                                                <label for="district_id">Kecamatan <span class="text-danger">*</span></label>
                                                <select :disabled="!form.city_id && $root.env_level == 'dpr'" v-model="form.district_id" name="district_id" id="tps" class="form-control" :class="{ 'is-invalid': form.errors.has('district_id') }">
                                                    <option value="" hidden>Pilih:</option>
                                                    <option v-for="item in locations.districts" :key="item.id" :value="item.id">{{ item.name }}</option>
                                                </select>
                                                <has-error :form="form" field="district_id"></has-error>
                                            </div>
                                        </div>
                                        <div class="col-md" v-if="form.role == 'village-co'">
                                            <div class="form-group">
                                                <label for="village_id">Desa / Kelurahan <span class="text-danger">*</span></label>
                                                <select :disabled="!form.district_id" v-model="form.village_id" name="village_id" id="tps" class="form-control" :class="{ 'is-invalid': form.errors.has('village_id') }">
                                                    <option value="" hidden>Pilih:</option>
                                                    <option v-for="item in locations.villages" :key="item.id" :value="item.id">{{ item.name }}</option>
                                                </select>
                                                <has-error :form="form" field="village_id"></has-error>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-if="!editmode">
                                <div class="bg-light p-3">
                                    <h5 class="modal-title">Akun Relawan</h5>
                                </div>
                                <div class="p-3">
                                    <div class="row">
                                        <div class="form-group col-lg">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input v-model="form.email" id="email" type="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" name="email" placeholder="Email...">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                        <div class="form-group col-lg">
                                            <label for="username">Username <span class="text-danger">*</span></label>
                                            <input v-model="form.username" id="username" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('username') }" name="username" placeholder="Username minimal 6 karakter...">
                                            <has-error :form="form" field="username"></has-error>
                                        </div>
                                        <div class="form-group col-lg">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <input v-model="form.password" id="password" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" name="password" placeholder="Password minimal 6 karakter...">
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="modal-footer border-top-0 bg-light">
                            <button type="button" class="btn btn-secondary d-none d-sm-inline-block" data-dismiss="modal">Batal</button>
                            <button-default type="submit" :disabled="form.busy" class="btn-block-xs">
                                <i class="fas fa-check mr-1"></i> <span v-html="editmode ? 'Simpan Perubahan' : 'Tambahkan'"></span>
                            </button-default>
                        </div>
                    </form>
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
            coordinators: [],
            roles: [],
            locations: {
                cities: [],
                districts: [],
                villages: [],
            },
            form: new Form({
                index: '',
                id: '',
                name: '',
                nik: '',
                address: '',
                phone: '',
                information: '',
                username: '',
                email: '',
                password: '',
                role: '',
                city_id: '',
                district_id: '',
                village_id: '',
            }),
            endpoint: '/coordinators'
        }
    },

    computed: {
        data() {
            return this.coordinators.map(item => {
                return {
                    id: item.id,
                    name: item.name,
                    phone: item.phone,
                    role: this.roles.filter(role => {
                        return role.code == item.role
                    })[0],
                    location: item.location
                }
            })
        }
    },

    watch: {
        'form.city_id'(value) {
            axios.get('/city/' + value)
            .then(({ data }) => {
                this.locations.districts = data.districts
                this.form.district_id = ''
                this.form.village_id = ''
            })
        },
        'form.district_id'(value) {
            axios.get('/district/' + value)
            .then(({ data }) => {
                this.locations.villages = data.villages
                this.form.village_id = ''
            })
        }
    },

    methods: {
        init() {
            axios.get(this.endpoint, {
                params: this.query
            })
            .then(({ data }) => {
                this.coordinators = data.data
                this.roles = data.roles
                if (this.$root.env_level == 'dpr') {
                    this.locations.cities = data.dapil
                } else {
                    this.locations.districts = data.dapil
                }
            })
        },
        modal(action) {
            $('#coordinatorModal').modal(action)
        },
        create() {
            this.editmode = false
            this.form.reset()
            this.form.clear()
            this.modal('show')
        },
        store() {
            this.form.post(this.endpoint)
            .then(({ data }) => {
                this.coordinators.push(data.data)
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(() => {})
        },
        edit(data, index) {
            this.editmode = true
            this.form.reset()
            this.form.clear()
            this.form.fill(data)
            this.form.index = index
            this.modal('show')
        },
        update() {
            this.form.patch(this.endpoint + '/' + this.form.id)
            .then(({ data }) => {
                this.coordinators.splice(this.form.index, 1, data.data);
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(() => {})
        },
        destroy(index, id) {
            this.$confirm.delete().then((result) => {
                if (result.value) {
                    this.form.delete(this.endpoint + '/' + id)
                    .then(({ data }) => {
                        this.coordinators.splice(index, 1);
                        toast({ type: 'success', title: data.message })
                    })
                    .catch(() => {
                        toast({ type: 'error', title: 'Terjadi Kesalahan!' });
                    });
                }
            })
        }
    },

    created() {
        this.init()
    }
}
</script>
