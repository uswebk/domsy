<template>
  <div v-if="loading" style="text-align: center">
    <v-sheet color="grey lighten-4" class="pa-3">
      <v-progress-circular indeterminate color="#2EBFAF"></v-progress-circular>
    </v-sheet>
  </div>
  <div v-else>
    <v-card>
      <v-card color="#2EBFAF" dark tile style="box-shadow: none">
        <v-card-title class="justify-end"> Domain </v-card-title>
        <v-card-subtitle>Domain Seller </v-card-subtitle>
        <v-card-title class="text-h5 pt-0">
          <v-avatar size="32" class="mr-4" color="#e8c46a">
            <v-icon>mdi-database</v-icon>
          </v-avatar>
          {{ $formattedPriceYen(totalPrice) }}
        </v-card-title>
      </v-card>
      <div class="mb-6"></div>
      <v-container class="px-5">
        <chart-pie-chart
          :shown="isChart"
          :data="chartData"
          :options="chartOptions"
        ></chart-pie-chart
      ></v-container>
      <v-card-subtitle style="text-align: center"
        >Summary: {{ summary }}</v-card-subtitle
      >
    </v-card>
  </div>
</template>

<script>
export default {
  name: 'DomainSummary',
  data() {
    return {
      loading: true,
      isChart: false,
      totalPrice: '',
      summary: '',
      chartData: {
        labels: ['Active', 'Inactive'],
        datasets: [
          {
            label: 'Number of domains',
            backgroundColor: ['#2EBFAF', '#CCCCCC'],
            data: [],
          },
        ],
      },
      chartOptions: {
        responsive: true,
      },
    }
  },
  async created() {
    this.loading = true
    await this.initDomainSeller()
    await this.initDomains()
    this.loading = false
  },
  methods: {
    async initDomainSeller() {
      const result = await this.$axios.get('/api/domain/total-seller')
      this.totalPrice = result.data.totalPrice
    },
    async initDomains() {
      const result = await this.$axios.get('/api/domain')
      const domains = result.data
      this.summary = domains.length
      let activeCount = 0
      let inactiveCount = 0
      for (const key in domains) {
        if (domains[key].is_active) {
          activeCount += 1
        } else {
          inactiveCount += 1
        }
      }
      this.chartData.datasets[0].data = [activeCount, inactiveCount]
      this.isChart = true
    },
  },
}
</script>
