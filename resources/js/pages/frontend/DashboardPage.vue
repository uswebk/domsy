<template>
  <v-main>
    <line-chart :chartdata="chartdata" :options="options" />
  </v-main>
</template>

<script>
import LineChart from '../../components/graph/SimpleChart.vue'

export default {
  name: 'LineChartContainer',
  components: { LineChart },
  data: () => ({
    chartdata: {
      datacollection: {
        labels: ['January', 'February'],
        datasets: [
          {
            label: 'Data One',
            backgroundColor: '#f87979',
            data: [40, 20],
          },
        ],
      },
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
    },
  }),
  async mounted() {},
}
</script>
