<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,

  props: ['isChart', 'chartData', 'options'],

  async mounted() {
    if (this.isChart) {
      this.renderChart(this.chartData, this.options)
    }
  },
}
</script>

<style></style>
