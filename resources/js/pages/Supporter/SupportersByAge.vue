<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="d-flex justify-content-between align-center">
                        <div class="card-title">
                            Perolehan Dukungan berdasarkan Usia
                        </div>
                        <div class="form-inline">
                            <select class="form-control" v-model="filter">
                                <option value="">DAPIL KOTA MAKASSAR 1</option>
                                <option v-for="(item, index) in locations" :value="index+1" :key="item.id">{{ item.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="chart-container">
                    <canvas id="chart" height="100"></canvas>
                </div>
                <div class="overlay d-flex justify-content-center" v-if="loading" style="align-items: center;">
                    <i class="fas fa-2x fa-spinner fa-spin"></i>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 col-sm">
                            <div class="description-block border-right">
                                <h5 class="description-header">{{ young + mid + old }}</h5>
                                <span class="description-text">TOTAL DUKUNGAN</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm">
                            <div class="description-block border-right">
                                <h5 class="description-header">{{ young }}</h5>
                                <span class="description-text">Usia 17-20 Tahun</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm">
                            <div class="description-block border-right">
                                <h5 class="description-header">{{ mid }}</h5>
                                <span class="description-text">Usia 21-40 Tahun</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm">
                            <div class="description-block">
                                <h5 class="description-header">{{ old }}</h5>
                                <span class="description-text">Usia 41 Tahun Keatas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            locations: [],
            young: 0,
            mid: 0,
            old: 0,
            filter: '',
            loading: true,
        }
    },
    watch: {
        filter(value) {
            if (value != '') {
                let locations = this.locations[value-1]
                let params = '&key=' + locations.alias + '&id=' + locations.id
                this.getChartData(params)
            } else {
                this.getChartData()
            }
            this.loading = true
        }
    },
    methods: {
        getChartData(filter = '') {
            axios.get('/supporters?chartBy=age' + filter)
            .then(({ data }) => {
                this.resetChart();
                this.initChartByGender(data.chart)
                this.young = data.chart.young.reduce((a,b) => a + b, 0)
                this.mid = data.chart.mid.reduce((a,b) => a + b, 0)
                this.old = data.chart.old.reduce((a,b) => a + b, 0)
                this.locations = data.locations
            })
            .catch()
        },
        initChartByGender(data) {
            var chart = document.getElementById('chart');
            var myChart = new Chart(chart, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Usia 17-20',
                            data: data.young,
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderWidth: 0
                        },
                        {
                            label: 'Usia 21-40',
                            data: data.mid,
                            backgroundColor: 'rgba(245, 120, 66)',
                            borderWidth: 0
                        },
                        {
                            label: 'Usia 41 keatas',
                            data: data.old,
                            backgroundColor: 'rgba(222, 222, 222)',
                            borderWidth: 0
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
            this.loading = false;
        },
        resetChart() {
            $('#chart').remove(); // this is my <canvas> element
            $('#chart-container').append('<canvas id="chart" height="100"></canvas>');
        }
    },
    mounted() {
        this.$root.back_button = true
        this.getChartData();
    }
}
</script>
