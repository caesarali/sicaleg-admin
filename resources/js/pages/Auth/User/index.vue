<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary app-shadow" @click="create">
                            <i class="fas fa-plus mr-1"></i> Administrator
                        </button>
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
                                Manajement Akun Pengguna
                            </div>
                            <div class="card-body p-0 table-responsive">
                                <table class="table table-hover nowrap">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" width="1%">#</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th class="text-center">Peran</th>
                                            <th class="text-center">Password</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in users.data" :key="item.id">
                                            <td class="text-center">{{ users.meta.from + index }}.</td>
                                            <td nowrap>{{ item.name }}</td>
                                            <td>{{ item.username }}</td>
                                            <td>{{ item.email }}</td>
                                            <td class="text-center">
                                                <span v-for="role in item.roles" :key="role.id" class="badge badge-secondary">{{ role.name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" @click.prevent="reset(item.id)" class="badge badge-warning">
                                                    <i class="fas fa-redo mr-1"></i> Reset
                                                </a>
                                            </td>
                                            <td nowrap class="text-right">
                                                <a href="#" @click.prevent="edit(item)" class="text-secondary mx-2">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a href="#" @click.prevent="destroy(item.id)" class="text-secondary ml-2">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <row-empty :colspan="7" v-if="!users.data.length"></row-empty>
                                    </tbody>
                                </table>
                            </div>
                            <div class="overlay d-flex justify-content-center" v-if="$root.isLoading" style="align-items: center;">
                                <i class="fas fa-2x fa-spinner fa-spin"></i>
                            </div>
                        </div>
                        <paginate v-if="Object.keys(users.meta).length > 0 && users.meta.las_page > 1"
                            v-model="users.meta.current_page"
                            :page-count="users.meta.last_page"
                            :click-handler="getusers"
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

        <div class="modal fade" id="formModal" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-orange">
                        <h5 class="modal-title">
                            <span v-text="editmode ? 'Data Pengguna' : 'Akun Administrator'"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? update() : store()" autocomplete="off">
                        <div class="modal-body pb-0">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" id="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" v-model="form.name" placeholder="Nama..." required>
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" id="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" v-model="form.email" placeholder="Email..." required>
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" name="username" id="username" class="form-control" :class="{ 'is-invalid': form.errors.has('username') }" v-model="form.username" placeholder="Username..." autocomplete="nope" required>
                                    <has-error :form="form" field="username"></has-error>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" id="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" v-model="form.password" :placeholder="editmode ? 'Password baru...' : 'Password...'" autocomplete="new-password" :required="!editmode">
                                    <has-error :form="form" field="password"></has-error>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            editmode: false,
            users: {
                data: [],
                meta: {},
                links: {}
            },
            form: new Form({
                id: '',
                name: '',
                username: '',
                email: '',
                password: '',
            })
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
            this.init()
        }, 300),
        init(page = 1) {
            axios.get('/users', {
                params: {
                    page: page,
                    keyword: this.$root.keywords
                }
            })
            .then(({ data }) => this.users = data )
            .catch()
            .then(() => {
                this.$root.isSearching = false
                this.$root.isLoading = false
            })
        },
        create() {
            this.editmode = false
            this.form.reset()
            this.form.clear()
            this.modal('show')
        },
        store() {
            this.form.post('/users')
            .then(({ data }) => {
                this.init()
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch()
        },
        edit(data) {
            this.editmode = true
            this.form.reset()
            this.form.clear()
            this.form.fill(data)
            this.modal('show')
        },
        update() {
            this.form.patch('/users/' + this.form.id)
            .then(({ data }) => {
                this.init()
                this.modal('hide')
                toast({type: 'success', text: data.message})
            })
            .catch(() => {})
        },
        reset(id) {
            this.form.post('/users/' + id + '/reset')
            .then(({ data }) => {
                toast({ type: 'success', title: data.message })
            })
            .catch(() => {
                toast({ type: 'error', title: 'Terjadi Kesalahan!' });
            });
        },
        destroy(id) {
            this.$confirm.delete().then((result) => {
                if (result.value) {
                    this.form.delete('/users/' + id)
                    .then(({ data }) => {
                        this.init()
                        toast({ type: 'success', title: data.message })
                    })
                    .catch(() => {
                        toast({ type: 'error', title: 'Terjadi Kesalahan!' });
                    });
                }
            })
        },
        modal(action) {
            $('#formModal').modal(action)
        }
    },

    mounted() {
        this.init()
    }
}
</script>
