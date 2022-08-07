<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,

  props: ['isChart', 'chartData', 'options'],

  async mounted() {
    if (this.isChart) {
      this.renderChart(this.chartData, this.options)
    }
  },
}
</script>
