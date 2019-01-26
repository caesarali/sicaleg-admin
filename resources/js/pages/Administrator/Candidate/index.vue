<template>
    <section class="content">
        <div class="container-fluid mt-3">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8">
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
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-images mr-1 text-secondary"></i> Lihat Foto
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-upload mr-1 text-secondary"></i> Ubah Foto
                                </a>
                            </div>
                        </div>
                        <div class="widget-user-header bg-info-active mb-3">
                            <h3 class="widget-user-username text-center">{{ profile.name }}</h3>
                            <h5 class="widget-user-desc text-center">NO. {{ profile.number }}</h5>
                        </div>
                        <div class="widget-user-image mt-3">
                            <img class="img-circle elevation-2 bg-gray" src="/images/sipileg-logo-mono.png" alt="User Avatar" width="100%" height="auto">
                        </div>
                        <div class="card-footer">
                            <div class="description-block">
                                <h5 class="description-header">Calon Legislatif</h5>
                                <span class="description-text text-uppercase">{{ $root.env_level }}</span>
                            </div>
                        </div>
                    </div>
                    <dapil-component :name="profile.dapil_name" :locations="profile.dapil_locations" />
                </div>
            </div>
        </div>

        <div class="modal fade" id="candidateModal" role="dialog" aria-hidden="true">
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
                                <label for="locationable_name" class="col-sm-3 col-form-label">Dapil</label>
                                <div class="col-5 col-sm-4">
                                    <input v-model="form.locationable_name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('locationable_name') }" name="locationable_name" placeholder="Nama Dapil, Ex: DAPIL 1 SULSEL..">
                                    <has-error :form="form" field="locationable_name"></has-error>
                                </div>
                                <div class="col-7 col-sm-5">
                                    <select name="locationable_id" id="locationable_id" v-model="form.locationable_id" class="form-control" :class="{ 'is-invalid': form.errors.has('locationable_id') }">
                                        <option value="" hidden>Provinsi:</option>
                                        <option :value="item.id" v-for="item in provinces" :key="item.id">
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
    </section>
</template>

<script>
import DapilComponent from './DapilComponent'
export default {
    components: {
        DapilComponent
    },

    data() {
        return {
            endpoint: '/candidate/profile/',
            profile: [],
            provinces: [],
            form: new Form({
                id: '',
                name: '',
                number: '',
                locationable_id: '',
                locationable_name: '',
            })
        }
    },

    methods: {
        getProfile() {
            axios.get(this.endpoint)
            .then(({ data }) => { this.profile = data.data })
            .catch(({ message }) => { toast({ type: 'error', title: message }) })
        },

        getProvinces() {
            axios.get('/provinces')
            .then(({ data }) => { this.provinces = data })
            .catch(({ message }) => { toast({ type: 'error', title: message }) })
        },
        edit() {
            this.form.fill(this.profile)
            this.modal('show')
        },
        update() {
            this.form.patch(this.endpoint + this.form.id)
            .then(({ data }) => {
                this.profile = data.data
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(({ message }) => { toast({ type: 'error', title: message }) })
        },
        modal(action) {
            $('#candidateModal').modal(action)
        }
    },

    created() {
        axios.all([this.getProfile(), this.getProvinces()]);
        this.$root.back_button = false;
    }
}
</script>
