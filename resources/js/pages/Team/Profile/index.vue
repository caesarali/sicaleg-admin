<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <div class="card">
                <div class="card-body py-2">
                    <div class="row" v-if="Object.keys('profile').length">
                        <div class="col-12 col-md">
                            <div class="form-row">
                                <label class="col-sm-5 col-md-3 col-form-label d-flex justify-content-sm-between pr-sm-0 font-weight-bold">
                                    Nama <span class="ml-1"> :</span>
                                </label>
                                <div class="col-sm">
                                    <p class="form-control-plaintext">{{ profile.name }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-5 col-md-3 col-form-label d-flex justify-content-sm-between pr-sm-0 font-weight-bold">
                                    NIK <span class="ml-1"> :</span>
                                </label>
                                <div class="col-sm">
                                    <p class="form-control-plaintext">{{ profile.nik }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-5 col-md-3 col-form-label d-flex justify-content-sm-between pr-sm-0 font-weight-bold">
                                    Alamat <span class="ml-1"> :</span>
                                </label>
                                <div class="col-sm">
                                    <p class="form-control-plaintext">{{ profile.address }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-5 col-md-3 col-form-label d-flex justify-content-sm-between pr-sm-0 font-weight-bold">
                                    Telp/HP <span class="ml-1"> :</span>
                                </label>
                                <div class="col-sm">
                                    <p class="form-control-plaintext">{{ profile.phone }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-5 col-md-3 col-form-label d-flex justify-content-sm-between pr-sm-0 font-weight-bold">
                                    Peran <span class="ml-1"> :</span>
                                </label>
                                <div class="col-sm" v-if="Object.keys(profile).length">
                                    <p class="form-control-plaintext">{{ profile.user.role.display_name }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-5 col-md-3 col-form-label d-flex justify-content-sm-between pr-sm-0 font-weight-bold">
                                    Lokasi <span class="ml-1"> :</span>
                                </label>
                                <div class="col-sm" v-if="Object.keys(profile).length">
                                    <p class="form-control-plaintext">{{ profile.locationable.detail }}</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <label class="col-sm-5 col-md-3 col-form-label d-flex justify-content-sm-between pr-sm-0 font-weight-bold">
                                    Kontribusi Dukungan <span class="ml-1"> :</span>
                                </label>
                                <div class="col-sm">
                                    <p class="form-control-plaintext">{{ profile.supporters_count }} Suara</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 my-3 my-md-0">
                            <canvas id="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <activities v-if="id" :id="id" />
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
    watch: {
        profile() {
            this.chart()
        }
    },
    methods: {
        getProfile() {
            axios.get('/volunteers/' + this.id)
            .then(({ data }) => this.profile = data)
            .catch()
            .then()
        },

        chart() {
            let contribution = this.profile.supporters_count
            let other = this.profile.others
            let ctx = document.getElementById('chart');
            let chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Kontribusi', 'Sisa'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [contribution, other],
                        backgroundColor: [
                            'rgba(21, 140, 186)',
                            'rgb(214, 214, 214)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        position: 'left'
                    }
                }
            })
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
