<template>
  <span>
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
        <chart-line-chart :data="dataSet" :options="options"></chart-line-chart>
      </v-card>
    </div>
  </span>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DomainTransaction',
  data() {
    return {
      loading: true,
      dataSet: {
        type: 'line',
        labels: [],
        datasets: [
          {
            type: 'line',
            label: 'Number of Domains',
            backgroundColor: '#5684d5',
            data: [],
            yAxisID: 'y',
            xAxisID: 'x',
            fill: false,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: {
              display: false,
            },
            title: {
              display: true,
              text: 'Purchased Month',
            },
          },
          y: {
            beginAtZero: true,
            type: 'linear',
            ticks: {
              stepSize: 20,
            },
            grid: {
              display: false,
            },
          },
        },
      },
    }
  },
  computed: {
    ...mapGetters('dashboard/domains', ['countOfDomains', 'labels']),
  },
  watch: {
    countOfDomains() {
      this.dataSet.datasets[0].data = this.countOfDomains
    },
    labels() {
      this.dataSet.labels = this.labels
    },
  },
  async created() {
    this.loading = true
    await this.fetchTransactionByMonths(6)
    this.loading = false
  },
  methods: {
    ...mapActions('dashboard/domains', ['fetchTransactionByMonths']),
  },
}
</script>
