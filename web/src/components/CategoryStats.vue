<script>
import Chart from './Chart'
import color from 'color-generator'

export default {
  name: 'w-category-stats',
  extends: Chart,
  props: {
    categories: {
      type: Array,
      required: true
    },
    values: {
      type: Array,
      required: true
    }
  },
  mounted () {
    this.renderChart('doughnut', {
      labels: this.categories,
      datasets: [
        {
          data: this.values,
          backgroundColor: this.categories.map(() => color().hexString())
        }
      ]
    }, {
      responsive: false,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      }
    })
  }
}
</script>