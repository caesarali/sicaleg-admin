<template>
    <div class="card">
        <div class="card-header">
            Top Kordinator & Relawan
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
                <li class="item" v-for="(item, index) in volunteers" :key="index">
                    <div class="product-info ml-1">
                        <a href="javascript:void(0)" class="product-title">
                            {{ item.name }}
                            <span class="badge badge-info float-right">{{ item.supporters_count }} Suara</span>
                        </a>
                        <span class="product-description">
                            {{ item.locationable.detail }}
                        </span>
                    </div>
                </li>
            </ul>
        </div>
        <div class="card-footer text-center">
            <router-link :to="{ name: 'monitoring' }" class="text-uppercase">
                <i class="fas fa-angle-double-right mr-1"></i> Monitoring
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            volunteers: {}
        }
    },
    methods: {
        getTopVolunteers() {
            axios.get('/monitoring/top-volunteers')
            .then(({ data }) => this.volunteers = data)
            .catch()
            .then(() => this.$root.isLoading = false)
        }
    },
    mounted() {
        this.getTopVolunteers()
    }
}
</script>
