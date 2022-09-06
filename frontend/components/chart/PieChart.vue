<template>
  <PieChart :chart-data="data" :options="options" />
</template>

<script>
import { Chart, registerables } from 'chart.js'
import { PieChart } from 'vue-chart-3'
Chart.register(...registerables)

export default {
  components: {
    PieChart,
  },
  props: {
    data: {
      default: null,
      type: Object,
      required: true,
    },
    options: {
      default: null,
      type: Object,
      required: true,
    },
  },
}
</script>
