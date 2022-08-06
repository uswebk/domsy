<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  mounted() {
    this.renderChart(
      {
        labels: ['Active', 'Inactive'],
        datasets: [
          {
            label: 'Number of domains',
            backgroundColor: ['#2EBFAF', '#CCCCCC'],
            data: [20, 4],
          },
        ],
      },
      {
        responsive: true,
      }
    )
  },
}
</script>

<style></style>
