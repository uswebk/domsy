<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,

  data() {
    return {
      data: {
        labels: ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
        datasets: [
          {
            label: 'Number of domains',
            backgroundColor: '#2EBFAF',
            data: [20, 4, 11, 14, 16, 40],
            fill: false,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          xAxes: [
            {
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Purchased Month',
              },
            },
          ],
          yAxes: [
            {
              display: true,
              scaleLabel: {
                display: false,
                labelString: 'Value',
              },
              autoSkip: true,
              ticks: {
                stepSize: 10,
              },
            },
          ],
        },
      },
    }
  },
  mounted() {
    this.renderChart(this.data, this.options)
  },
}
</script>

<style></style>
