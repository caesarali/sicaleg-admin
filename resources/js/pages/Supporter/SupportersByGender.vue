<template>
    <div class="content">
        <div class="container-fluid mt-3">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <div class="d-flex justify-content-between align-center">
                        <div class="card-title">
                            Perolehan Dukungan berdasarkan Jenis Kelamin
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
                        <div class="col-12 col-sm-4">
                            <div class="description-block border-right">
                                <h5 class="description-header">{{ male + female }}</h5>
                                <span class="description-text">TOTAL</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="description-block border-right">
                                <h5 class="description-header">{{ male }}</h5>
                                <span class="description-text">LAKI-LAKI</span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">{{ female }}</h5>
                                <span class="description-text">Perempuan</span>
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
            male: 0,
            female: 0,
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
            axios.get('/supporters?chartBy=gender' + filter)
            .then(({ data }) => {
                this.resetChart();
                this.initChartByGender(data.chart)
                this.male = data.chart.male.reduce((a,b) => a + b, 0)
                this.female = data.chart.female.reduce((a,b) => a + b, 0)
                this.locations = data.locations
            })
            .catch()
        },
        initChartByGender(data) {
            var genderChart = document.getElementById('chart');
            var myChart = new Chart(genderChart, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [
                        {
                            label: 'Laki-laki',
                            data: data.male,
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.9)',
                            borderWidth: 1
                        },
                        {
                            label: 'Perempuan',
                            data: data.female,
                            backgroundColor: 'rgb(245, 120, 66)',
                            borderColor: 'rgb(245, 120, 66)',
                            borderWidth: 1
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
