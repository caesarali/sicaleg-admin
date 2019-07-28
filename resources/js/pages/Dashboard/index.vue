<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL RELAWAN</span>
                            <span class="info-box-number">{{ relawan }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL DPT</span>
                            <span class="info-box-number">{{ dpt }}</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL DUKUNGAN</span>
                            <span class="info-box-number">{{ dukungan }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TARGET ({{ target.percent }}%)</span>
                            <span class="info-box-number">{{ target.total }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-8">
                    <supporters-chart></supporters-chart>
                </div>
                <div class="col-lg-4">
                    <div class="card card-widget widget-user" v-if="Object.keys(caleg).length">
                        <div class="widget-user-header bg-info-active">
                            <h3 class="widget-user-username">{{ caleg.name }}</h3>
                            <h5 class="widget-user-desc">No. Urut {{ caleg.number }}</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="/images/man.png" alt="User Avatar">
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">CALEG</h5>
                                        <span class="description-text text-uppercase">{{ caleg.level }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">DAPIL</h5>
                                        <span class="description-text">{{ caleg.dapil }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">PARTAI</h5>
                                        <span class="description-text">{{ caleg.partai }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <top-volunteers />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TopVolunteers from "./TopVolunteers"
import SupportersChart from "./SupportersChart"
export default {
    components: { SupportersChart, TopVolunteers },
    data() {
        return {
            relawan: 0,
            dpt: 0,
            dukungan: 0,
            target: {
                percent: 0,
                total: 0
            },
            caleg: []
        }
    },
    methods: {
        getDashboarData() {
            axios.get('/dashboard')
            .then(({ data }) => {
                this.relawan = data.data.relawan
                this.dpt = data.data.dpt
                this.dukungan = data.data.dukungan
                this.target = data.data.target
                this.caleg = data.data.caleg
            })
        }
    },
    mounted() {
        this.getDashboarData();
    }
}
</script>
