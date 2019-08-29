<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL RELAWAN</span>
                            <span class="info-box-number">{{ monitoring.total_volunteers }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TANPA KONTRIBUSI</span>
                            <span class="info-box-number">{{ monitoring.uncontributed_volunteers }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL DUKUNGAN</span>
                            <span class="info-box-number">{{ monitoring.total_supporters }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">TARGET</span>
                            <span class="info-box-number">{{ monitoring.target_supporters }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Top Kordinator & Relawan
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <li class="item" v-for="item in monitoring.top_volunteers" :key="item.id">
                                    <div class="product-info ml-1">
                                        <router-link :to="{ name: 'team.profile', params: { id: item.nik } }" class="product-title">
                                            {{ item.name }}
                                            <span class="badge badge-info float-right">{{ item.supporters_count }} Suara</span>
                                        </router-link>
                                        <span class="product-description">
                                            {{ item.user.role.display_name }}
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 order-md-first">
                    <activities></activities>
                </div>
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
            monitoring: {
                top_volunteers: [],
                total_volunteers: 0,
                uncontributed_volunteers: 0,
                total_supporters: 0,
                target_supporters: 0
            }
        }
    },
    methods: {
        getMonitoring() {
            axios.get('/monitoring')
            .then(({ data }) => this.monitoring = data)
            .catch()
            .then()
        }
    },
    mounted() {
        this.getMonitoring()
    }
}
</script>
