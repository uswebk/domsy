<template>
  <PieChart :chart-data="data" :options="options" :v-show="shown" />
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
    shown: {
      default: false,
      type: Boolean,
      required: true,
    },
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
