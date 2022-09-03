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
      <v-card class="pa-5">
        <v-card-title>Billing Transition</v-card-title>
        <chart-line-chart
          :shown="isChart"
          :data="chartData"
          :options="chartOptions"
        ></chart-line-chart>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DomainBillings',
  data() {
    return {
      loading: true,
      isChart: false,
      chartData: {
        labels: [],
        datasets: [
          {
            label: 'Billings Price',
            backgroundColor: '#2EBFAF',
            data: [],
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
                labelString: 'Billing Month',
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
                stepSize: 10000,
              },
            },
          ],
        },
      },
    }
  },
  async created() {
    this.loading = true
    await this.initDomains()
    this.loading = false
  },
  methods: {
    async initDomains() {
      const result = await this.$axios.get(
        '/api/dealing/billings/transaction?months=12'
      )
      const labels = []
      const data = []
      for (const key in result.data) {
        labels.push(key)
        data.push(result.data[key])
      }
      this.chartData.labels = labels
      this.chartData.datasets[0].data = data
      this.isChart = true
    },
  },
}
</script>
