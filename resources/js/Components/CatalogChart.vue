<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Diagram Lingkaran Katalog Berdasarkan Kategori</div>
          <div class="card-body">
            <div id="chart-container" style="height: 400px;">
              <apexchart type="pie" height="400" :options="chartOptions" :series="series"></apexchart>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import VueApexCharts from 'vue3-apexcharts';

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data() {
    return {
      chartOptions: {
        chart: {
          type: 'pie',
          fontFamily: 'Nunito, sans-serif',
        },
        labels: [],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }],
        dataLabels: {
          enabled: true,
          formatter: function (val, opts) {
            return opts.w.config.labels[opts.seriesIndex] + ': ' + val.toFixed(1) + '%';
          }
        },
        title: {
          text: 'Distribusi Katalog per Kategori',
          align: 'center',
          style: {
            fontSize: '18px',
            fontWeight: 'bold',
          }
        },
        legend: {
          position: 'right',
          offsetY: 0,
        }
      },
      series: [],
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('/api/catalogs-by-category');
        const data = response.data;
        
        // Extract labels and values for the chart
        this.chartOptions.labels = data.map(item => item.name);
        this.series = data.map(item => item.value);
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }
  }
};
</script>