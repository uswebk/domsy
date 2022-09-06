<template>
  <LineChart :chart-data="data" :options="options" />
</template>

<script>
import { Chart, registerables } from 'chart.js'
import { LineChart } from 'vue-chart-3'
Chart.register(...registerables)

export default {
  components: {
    LineChart,
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
