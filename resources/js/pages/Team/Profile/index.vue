<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <div class="card">
                <div class="card-body p-2">
                    <table class="table table-borderless" v-if="Object.keys('profile').length > 0">
                        <tbody>
                            <tr>
                                <td class="d-flex justify-content-between py-1 font-weight-bold">Nama <span>:</span></td>
                                <td class="py-1">{{ profile.name }}</td>
                            </tr>
                            <tr>
                                <td class="d-flex justify-content-between py-1 font-weight-bold">NIK <span>:</span></td>
                                <td class="py-1">{{ profile.nik }}</td>
                            </tr>
                            <tr>
                                <td class="d-flex justify-content-between py-1 font-weight-bold">Alamat <span>:</span></td>
                                <td class="py-1">{{ profile.address }}</td>
                            </tr>
                            <tr>
                                <td class="d-flex justify-content-between py-1 font-weight-bold">Telp/HP <span>:</span></td>
                                <td class="py-1">{{ profile.phone }}</td>
                            </tr>
                            <tr>
                                <td class="d-flex justify-content-between py-1 font-weight-bold">Peran <span>:</span></td>
                                <td class="py-1">{{ profile.user.roles[0].display_name }}</td>
                            </tr>
                            <tr>
                                <td class="d-flex justify-content-between py-1 font-weight-bold">Lokasi <span>:</span></td>
                                <td class="py-1">{{ profile.locationable.detail }}</td>
                            </tr>
                            <tr>
                                <td class="d-flex justify-content-between py-1 font-weight-bold">Kontribusi Dukungan <span>:</span></td>
                                <td class="py-1">
                                    <b>{{ profile.contribution }}%</b> dari total dukungan / {{ profile.supporters_count }} Orang</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <activities v-if="id" :id="id" />
            </div>
        </div>
    </div>
</template>

<script>
import Activities from "./Activities"
export default {
    components: { Activities },
    data() {
        return {
            profile: []
        }
    },
    computed: {
        id() {
            return this.$route.params.id
        }
    },
    methods: {
        getProfile() {
            axios.get('/volunteers/' + this.id)
            .then(({ data }) => this.profile = data)
            .catch()
            .then()
        }
    },
    mounted() {
        if (this.id) {
            this.getProfile()
        }
        this.$root.back_button = true
    }
}
</script>
