<template>
    <div class="card">
        <div class="card-header border-bottom-0">
            Perolehan Dukungan Per Lokasi Daerah Pilih
        </div>
        <div class="card-body" id="chart-container">
            <canvas id="chart" height="160"></canvas>
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
</template>

<script>
export default {
    data() {
        return {
            male: 0,
            female: 0,
            loading: true,
        }
    },
    methods: {
        getChartData() {
            axios.get('/supporters?chartBy=gender')
            .then(({ data }) => {
                this.initChartByGender(data.chart)
                this.male = data.chart.male.reduce((a,b) => a + b, 0)
                this.female = data.chart.female.reduce((a,b) => a + b, 0)
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
        }
    },
    mounted() {
        this.getChartData();
    }
}
</script>
