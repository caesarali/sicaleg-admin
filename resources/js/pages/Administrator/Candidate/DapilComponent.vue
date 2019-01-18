<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <badge-default>
                    {{ name }}
                </badge-default>
                <a href="#" @click.prevent="create" class="text-secondary ml-auto float-right">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr v-for="(item, index) in dapil" :key="item.id">
                            <td class="text-center" width="1%">{{ index+1 }}.</td>
                            <td>{{ item.name }}</td>
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
        <div class="modal fade" id="dapilModal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Daerah Pemilihan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="store()">
                        <div class="modal-body pb-0">
                            <div class="form-group">
                                <select v-model="form.locationable_id" name="locationable_id" class="form-control" :class="{ 'is-invalid': form.errors.has('locationable_id') }">
                                    <option value="" hidden>Pilih:</option>
                                    <option :value="item.id" v-for="item in locations" :key="item.id">{{ item.name }}</option>
                                </select>
                                <has-error :form="form" field="locationable_id"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 bg-light">
                            <button-default type="submit" :disabled="form.busy" class="btn-sm btn-block">
                                <i class="fas fa-plus"></i> <span class="ml-1">Tambahkan</span>
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
    props: {
        name: String
    },
    data() {
        return {
            locations: [],
            dapil: [],
            form: new Form({
                id: '',
                locationable_id: ''
            })
        }
    },
    methods: {
        create() {
            this.form.reset()
            this.form.clear()
            this.modal('show')
        },
        store() {
            this.form.post('/candidate/locations')
            .then(({ data }) => {
                this.dapil.push(data.data)
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch()
        },
        destroy(index, id) {
            this.$confirm.delete().then((result) => {
                if (result.value) {
                    this.form.delete('/candidate/locations/' + id)
                    .then(({ data }) => {
                        this.dapil.splice(index, 1);
                        toast({ type: 'success', title: data.message })
                    })
                    .catch(() => {
                        toast({ type: 'error', title: 'Terjadi Kesalahan!' });
                    });
                }
            })
        },

        modal(action) {
            $('#dapilModal').modal(action);
        }
    },

    created() {
        axios.get('/candidate/locations').then(({ data }) => {
            this.dapil = data.data
            this.locations = data.locations
        })
    }
}
</script>
