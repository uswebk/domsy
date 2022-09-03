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
        <chart-line-chart
          :shown="shown"
          :data="dataSet"
          :options="options"
        ></chart-line-chart>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DomainTransaction',
  data() {
    return {
      loading: true,
      shown: false,
      dataSet: {
        labels: [],
        datasets: [
          {
            label: 'Number of domains',
            backgroundColor: '#2EBFAF',
            data: [],
            fill: false,
            responsive: true,
            maintainAspectRatio: false,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Purchased Month',
            },
          },

          y: {
            grid: {
              display: false,
              drawBorder: false,
            },
            display: true,
            beginAtZero: true,
            scaleLabel: {
              display: false,
              labelString: 'Value',
            },
            autoSkip: true,
            ticks: {
              stepSize: 10,
            },
          },
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
      const result = await this.$axios.get('/api/domain/transaction?months=6')
      const labels = []
      const data = []
      for (const key in result.data) {
        labels.push(key)
        data.push(result.data[key])
      }
      this.dataSet.labels = labels
      this.dataSet.datasets[0].data = data
      this.shown = true
    },
  },
}
</script>
