<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: {
    label: {
      type: String,
    },
    chartData: {
      type: Array,
    },
    option: {
      type: Object,
    },
  },
}
</script>
