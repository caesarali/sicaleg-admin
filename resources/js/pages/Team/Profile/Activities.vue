<template>
    <div>
        <div class="card">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="1%">#</th>
                            <th width="1%" class="text-center">Tanggal</th>
                            <th>Aktifitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in activities.data" :key="index">
                            <td>{{ activities.meta.from + index }}.</td>
                            <td class="text-center" nowrap>{{ item.date }}</td>
                            <td nowrap>
                                Menambahkan pendukung baru (<a href="#">{{ item.voter.name }} - {{ item.voter.nik }}</a>)
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
    props: ['id'],
    data() {
        return {
            activities: {}
        }
    },
    methods: {
        getActivities(page = 1) {
            axios.get('/monitoring/activities', {
                params: {
                    page: page,
                    user: this.id
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
