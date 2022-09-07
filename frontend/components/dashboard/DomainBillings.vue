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
        <chart-line-chart :data="dataSet" :options="options"></chart-line-chart>
      </v-card>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'DomainBillings',
  data() {
    return {
      loading: true,
      dataSet: {
        labels: [],
        datasets: [
          {
            label: 'Billing amount',
            backgroundColor: '#e8c46a',
            data: [],
            fill: true,
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
              text: 'Billing Month',
            },
          },
          y: {
            beginAtZero: true,
            grid: {
              display: false,
            },
          },
        },
      },
    }
  },
  computed: {
    ...mapGetters('dashboard/dealings', ['amounts', 'labels']),
  },
  watch: {
    amounts() {
      this.dataSet.datasets[0].data = this.amounts
    },
    labels() {
      this.dataSet.labels = this.labels
    },
  },
  async created() {
    this.loading = true
    await this.fetchAmountByMonths(12)
    this.loading = false
  },
  methods: {
    ...mapActions('dashboard/dealings', ['fetchAmountByMonths']),
  },
}
</script>
