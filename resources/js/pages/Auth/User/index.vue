<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <search-box></search-box>
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
                                        <tr v-for="(item, index) in data" :key="item.id">
                                            <td class="text-center">{{ meta.from + index }}.</td>
                                            <td nowrap>{{ item.name }}</td>
                                            <td>{{ item.username }}</td>
                                            <td>{{ item.email }}</td>
                                            <td class="text-center">
                                                <span v-for="role in item.roles" :key="role.id" class="badge badge-secondary">{{ role.name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" class="badge badge-warning">
                                                    <i class="fas fa-redo mr-1"></i> Reset
                                                </a>
                                            </td>
                                            <td nowrap class="text-right">
                                                <a href="#" @click.prevent="edit(index, dpt[index])" class="text-secondary mx-2">
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: [],
            meta: {},
            links: {},
            endpoint: '/users'
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
            return this.users.map(item => {
                return {
                    id: item.id,
                    name: item.name,
                    username: item.username,
                    email: item.email,
                    roles: item.roles,
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
            axios.get(this.endpoint, {
                params: {
                    page: page,
                    keyword: this.$root.keywords
                }
            })
            .then(({ data }) => {
                this.users = data.data
                this.meta = data.meta
                this.links = data.links
            })
            .catch()
            .then(() => this.$root.isSearching = false)
        },
        search: _.debounce(function() {
            this.init()
        }, 300),
        create() {},
        store() {},
        edit(index, data) {},
        update() {},
        destroy(index, id) {}
    },

    created() {
        this.init()
    }
}
</script>
