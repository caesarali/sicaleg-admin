<template>
    <div>
        <div class="card card-widget widget-user-2">
            <div class="widget-user-header">
                <div class="dropdown position-absolute" style="right: 15px; top: 10px">
                    <a href="#" class="text-secondary" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" @click.prevent="edit">
                            <i class="fas fa-pencil-alt mr-1 text-secondary"></i> Edit
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-images mr-1 text-secondary"></i> Show
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-upload mr-1 text-secondary"></i> Change
                        </a>
                    </div>
                </div>
                <div class="widget-user-image">
                    <img src="/images/flag.png" alt="Logo Partai">
                </div>
                <h3 class="widget-user-username mt-0">{{ party.name }}</h3>
                <h5 class="widget-user-desc">{{ party.fullname }}</h5>
            </div>
            <div class="card-footer p-0">
                <ul class="nav flex-column">
                    <li class="nav-item text-center">
                        <a href="#" class="nav-link text-secondary">
                            Nomor Urut {{ party.number }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="modal fade" id="partyForm" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Profil Partai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="update()">
                        <div class="modal-body pb-0">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Singkatan</label>
                                <div class="col-md-9">
                                    <input v-model="form.name" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" name="name" placeholder="Singkatan Nama Partai..">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fullname" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-md-9">
                                    <input v-model="form.fullname" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('fullname') }" name="fullname" placeholder="Nama Lengkap Partai..">
                                    <has-error :form="form" field="fullname"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="number" class="col-sm-3 col-form-label">No. Urut</label>
                                <div class="col-md-9">
                                    <input v-model="form.number" type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('number') }" name="number" placeholder="Nomor Urut Partai..">
                                    <has-error :form="form" field="number"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 bg-light">
                            <button type="button" class="btn btn-secondary btn-sm d-none d-sm-inline-block" data-dismiss="modal">Batal</button>
                            <button-default type="submit" :disabled="form.busy" class="btn-sm btn-block-xs">
                                <i class="fas fa-check mr-1"></i>Simpan
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
            party: [],
            form: new Form({
                id: '',
                name: '',
                fullname: '',
                number: ''
            })
        }
    },
    methods: {
        edit() {
            this.form.fill(this.party);
            this.modal('show');
        },
        update() {
            this.form.patch('/party/' + this.form.id)
            .then(({ data }) => {
                this.party = data.data
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(({ message }) => { toast({ type: 'error', title: message }) })
        },
        modal(action) {
            $('#partyForm').modal(action)
        }
    },
    mounted() {
        axios.get('/party')
        .then(({ data }) => { this.party = data.data })
        .catch(({ message }) => { toast({ type: 'error', title: message }) })
    }
}
</script>

