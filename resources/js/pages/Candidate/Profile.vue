<template>
    <div>
        <div class="card card-widget widget-user d-flex">
            <div class="dropdown position-absolute" style="right: 15px; top: 10px">
                <a href="#" class="text-secondary" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" @click.prevent="edit">
                        <i class="fas fa-pencil-alt mr-1 text-secondary"></i> Edit Profil
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" @click.prevent="show">
                        <i class="fas fa-images mr-1 text-secondary"></i> Lihat Foto
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-upload mr-1 text-secondary"></i> Ubah Foto
                    </a>
                </div>
            </div>
            <div class="widget-user-header bg-info-active mb-3" style="height: 100px;">
                <h3 class="widget-user-username text-center">{{ profile.name }}</h3>
            </div>
            <div class="widget-user-image mt-3" style="top: 40px">
                <img class="img-circle bg-gray" src="/images/sipileg-logo-mono.png" alt="User Avatar" width="100%" height="auto">
            </div>
            <div class="card-footer">
                <div class="description-block">
                    <h5 class="description-header text-uppercase">CALEG {{ profile.level }}</h5>
                    <span class="description-text">Nomor Urut {{ profile.number }}</span>
                </div>
            </div>
        </div>

        <div class="modal fade" id="profileForm" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Profil Calon Legislatif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="update()">
                        <div class="modal-body pb-0">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-md-9">
                                    <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" name="name" placeholder="Nama Calon Legislatif..">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="number" class="col-sm-3 col-form-label">No. Urut</label>
                                <div class="col-md-9">
                                    <input v-model="form.number" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('number') }" name="number" placeholder="Nomor Urut Calon Legislatif..">
                                    <has-error :form="form" field="number"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dapil" class="col-sm-3 col-form-label">Dapil</label>
                                <div class="col-5 col-sm-4">
                                    <input v-model="form.dapil" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('dapil') }" name="dapil" placeholder="Nama Dapil, Ex: DAPIL 1 SULSEL..">
                                    <has-error :form="form" field="dapil"></has-error>
                                </div>
                                <div class="col-7 col-sm-5">
                                    <select name="locationable_id" id="locationable_id" v-model="form.locationable_id" class="form-control" :class="{ 'is-invalid': form.errors.has('locationable_id') }">
                                        <option value="" hidden>Lokasi:</option>
                                        <option :value="item.id" v-for="item in locations" :key="item.id">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="locationable_id"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 bg-light">
                            <button type="button" class="btn btn-secondary btn-sm d-none d-sm-inline-block" data-dismiss="modal">Batal</button>
                            <button-default type="submit" :disabled="form.busy" class="btn-sm btn-block-xs">
                                <i class="fas fa-check"></i> <span class="ml-1">Simpan</span>
                            </button-default>
                        </div>
                    </form>
                </div>
                <div class="text-center m-1 d-block d-sm-none" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-angle-double-up"></i>
                </div>
            </div>
        </div>

        <light-box ref="lightbox"></light-box>
    </div>
</template>

<script>
import Dapil from './Dapil'
export default {
    components: { Dapil },
    data() {
        return {
            profile: [],
            locations: [],
            form: new Form({
                id: '',
                name: '',
                number: '',
                dapil: '',
                locationable_id: '',
            }),
            image: {
                src: '/images/sipileg-logo.png',
                caption: 'asdasda'
            }
        }
    },
    methods: {
        getProfile() {
            axios.get('/candidate/profile')
            .then(({ data }) => {
                this.profile = data.data
                this.locations = data.locations
            })
            .catch(({ message }) => { toast({ type: 'error', title: message }) })
        },
        show() {
            this.$refs.lightbox.open(this.image)
        },
        edit() {
            this.form.fill(this.profile)
            this.modal('show')
        },
        update() {
            this.form.patch('/candidate/profile/' + this.form.id)
            .then(({ data }) => {
                this.profile = data.data
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(({ message }) => { toast({ type: 'error', title: message }) })
        },
        modal(action) {
            $('#profileForm').modal(action)
        }
    },
    created() {
        this.getProfile()
    }
}
</script>
