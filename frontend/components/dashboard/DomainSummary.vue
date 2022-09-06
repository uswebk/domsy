<template>
  <div>
    <v-card>
      <dashboard-domain-seller></dashboard-domain-seller>
      <div v-if="loading" style="text-align: center">
        <v-sheet color="grey lighten-4" class="pa-3">
          <v-progress-circular
            indeterminate
            color="#2EBFAF"
          ></v-progress-circular>
        </v-sheet>
      </div>
      <v-container v-else class="px-5">
        <chart-pie-chart
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
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DomainSummary',
  data() {
    return {
      loading: true,
      summary: '',
      chartData: {
        labels: ['Active', 'Inactive'],
        datasets: [
          {
            label: 'Number of domains',
            backgroundColor: ['#5684d5', '#CCCCCC'],
            data: [],
          },
        ],
      },
      chartOptions: {
        responsive: true,
      },
    }
  },
  computed: {
    ...mapGetters('dashboard/domains', ['activeSummary']),
  },
  watch: {
    activeSummary() {
      this.summary = this.activeSummary.total
      this.chartData.datasets[0].data = [
        this.activeSummary.active,
        this.activeSummary.inactive,
      ]
    },
  },
  async created() {
    this.loading = true
    await this.fetchActiveSummary()
    this.loading = false
  },
  methods: {
    ...mapActions('dashboard/domains', ['fetchActiveSummary']),
  },
}
</script>
