<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
                    </div>
                    <div class="col-auto">
                        <button-outline-success>
                            <i class="fas fa-file-import"></i>
                            <span class="d-none d-sm-inline ml-1"> Import</span>
                        </button-outline-success>
                        <button-default :click="create">
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
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>No. KK</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>TTL</th>
                                            <th>Status</th>
                                            <th>Gender</th>
                                            <th>Keterangan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr v-for="voter in voters.data" :key="voter.id">
                                            <td>{{ voter.id }}</td>
                                            <td nowrap>{{ voter.kk }}</td>
                                            <td nowrap>{{ voter.nik }}</td>
                                            <td nowrap>{{ voter.name }}</td>
                                            <td nowrap>{{ voter.place_of_birth }}, {{ voter.date_of_birth }}</td>
                                            <td nowrap>{{ voter.marital_status | marital }}</td>
                                            <td nowrap>{{ voter.gender | gender }}</td>
                                            <td nowrap>{{ voter.information ? voter.information : '-' }}</td>
                                            <td nowrap class="text-right">
                                                <a href="#" @click.prevent="show(voter)" class="text-secondary mx-2">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a href="#" @click.prevent="edit(voter)" class="text-secondary mx-2">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a href="#" @click.prevent="destroy(voter.id)" class="text-secondary ml-2">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- <div id="tpsModal" class="modal fade" role="dialog" aria-hidden="true">
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
        </div> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            dpt: [],
            form: new Form({
                id: '',
                voting_place_id: this.$route.params.tps_id,
                kk: '',
                nik: '',
                name: '',
                place_of_birth: '',
                date_of_birth: '',
                marital_status: 'b',
                gender: 'l',
                address_street: '',
                address_rt: '',
                address_rw: '',
                disability_id: '',
                information: ''
            }),
        }
    },

    methods: {
        create() {}
    }
}
</script>
