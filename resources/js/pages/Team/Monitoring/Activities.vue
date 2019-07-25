<template>
    <div>
        <div class="card">
            <div class="card-header border-bottom-0">
                Aktifitas Relawan
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr v-for="(item, index) in activities.data" :key="index">
                            <td width="1%">{{ activities.meta.from + index }}.</td>
                            <td width="1%" nowrap>
                                <router-link :to="{ name: 'team.profile', params: { id: item.user.volunteer.nik }}" v-if="item.user.volunteer">
                                    <b>{{ item.user.volunteer.name }}</b>
                                </router-link>
                                <a href="#" v-else><b>{{ item.user.name }}</b> <span class="text-muted">(Administrator)</span></a>
                                <br>
                                Menambahkan pendukung baru (<a href="#">{{ item.voter.name }} - {{ item.voter.nik }}</a>)
                            </td>
                            <td class="text-right">
                                <small class="text-secondary">{{ item.date }}</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <paginate v-if="Object.keys(activities).length && activities.data.length"
            v-model="activities.meta.current_page"
            :page-count="activities.meta.last_page"
            :click-handler="getActivities"
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
</template>

<script>
export default {
    data() {
        return {
            activities: {}
        }
    },
    methods: {
        getActivities(page = 1) {
            axios.get('/monitoring/activities', {
                params: {
                    page: page
                }
            })
            .then(({ data }) => this.activities = data)
            .catch()
            .then()
        }
    },

    mounted() {
        this.getActivities()
    }
}
</script>
