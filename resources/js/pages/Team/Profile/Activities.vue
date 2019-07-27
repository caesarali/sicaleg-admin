<template>
    <div class="table-responsive pt-2">
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
