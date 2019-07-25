<template>
    <div class="card">
        <div class="card-header">
            Top Kordinator & Relawan
        </div>
        <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
                <li class="item" v-for="item in volunteers" :key="item.id">
                    <div class="product-info ml-1">
                        <router-link :to="{ name: 'team.profile', params: { id: item.nik } }" class="product-title">
                            {{ item.name }}
                            <span class="badge badge-info float-right">{{ item.supporters_count }} Suara</span>
                        </router-link>
                        <span class="product-description">
                            {{ item.user.roles[0].display_name }}
                        </span>
                    </div>
                </li>
            </ul>
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
            .then()
        }
    },
    mounted() {
        this.getTopVolunteers()
    }
}
</script>
