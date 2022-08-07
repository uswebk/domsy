<template>
  <div>
    <div v-if="loading" style="text-align: center">
      <v-sheet color="grey lighten-4" class="pa-3">
        <v-progress-circular
          indeterminate
          color="#2EBFAF"
        ></v-progress-circular>
      </v-sheet>
    </div>
    <div v-else>
      <v-card class="pa-7">
        <line-chart
          :isChart="isChart"
          :chartData="chartData"
          :options="chartOptions"
        ></line-chart>
      </v-card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

import LineChart from '../../components/chart/LineChart.vue'

export default {
  components: { LineChart },

  data() {
    return {
      loading: true,
      isChart: false,
      chartData: {
        labels: [],
        datasets: [
          {
            label: 'Number of domains',
            backgroundColor: '#2EBFAF',
            data: [],
            fill: false,
          },
        ],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          xAxes: [
            {
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Purchased Month',
              },
            },
          ],
          yAxes: [
            {
              display: true,
              scaleLabel: {
                display: false,
                labelString: 'Value',
              },
              autoSkip: true,
              ticks: {
                stepSize: 10,
              },
            },
          ],
        },
      },
    }
  },

  methods: {
    async initDomains() {
      const result = await axios.get('/api/domains/transaction?months=6')

      let labels = []
      let data = []
      for (let key in result.data) {
        labels.push(key)
        data.push(result.data[key])
      }

      this.chartData.labels = labels
      this.chartData.datasets[0].data = data

      this.isChart = true
    },
  },

  async created() {
    this.loading = true

    await this.initDomains()

    this.loading = false
  },
}
</script>
