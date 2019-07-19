<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL RELAWAN</span>
                            <span class="info-box-number">{{ relawan }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL DPT</span>
                            <span class="info-box-number">{{ dpt }}</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL DUKUNGAN</span>
                            <span class="info-box-number">{{ dukungan }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TARGET (20%)</span>
                            <span class="info-box-number">{{ target }}</span>
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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top Kordinator & Relawan</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <li class="item" v-for="x in 3" :key="x">
                                    <div class="product-info ml-1">
                                        <a href="javascript:void(0)" class="product-title">
                                            Relawan x
                                            <span class="badge badge-info float-right">400 Suara</span>
                                        </a>
                                        <span class="product-description">
                                            Kordinator Tingkat Kecamatan
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="javascript:void(0)" class="text-uppercase">
                                <i class="fas fa-angle-double-right mr-1"></i> Monitoring
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SupportersChart from "./SupportersChart"
export default {
    components: { SupportersChart },
    data() {
        return {
            relawan: 0,
            dpt: 0,
            dukungan: 0,
            target: 0,
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
