<script>
import Chart from './Chart'

export default {
  name: 'w-overall-stats',
  extends: Chart,
  mounted () {
    this.renderChart('line', {
      labels: ['Jan', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
          label: 'Траты',
          borderColor: '#f87979',
          data: [40, 20, 12, 39, 10, 18, 39, 80, 40, ],
        },
        {
          label: 'Доходы',
          borderColor: '#288e36',
          data: [23, 12, 34, 67, 5, 39, 7, 90, ]
        }
      ]
    }, {
      responsive: true,
      maintainAspectRatio: false,
      datasets: {
        line: {
          fill: false,
          tension: 0.2
        }
      },
      elements: {
        point: {
          pointRadius: 0
        }
      },
      plugins: {
        legend: {
          display: false
        }
      }
    })
  }
}
</script>