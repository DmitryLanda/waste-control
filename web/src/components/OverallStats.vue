<script>
import Chart from './Chart'
import color from "color-generator";

export default {
  name: 'w-overall-stats',
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
  extends: Chart,
  mounted () {
    this.renderChart('line', {
      labels: this.categories,
      datasets: [
        {
          label: 'Расходы',
          borderColor: '#f87979',
          data: this.values,
        },
        // {
        //   label: 'Доходы',
        //   borderColor: '#288e36',
        //   data: [23, 12, 34, 67, 5, 39, 7, 90, ]
        // }
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
    // this.renderChart('doughnut', {
    //   labels: this.categories,
    //   datasets: [
    //     {
    //       data: this.values,
    //       backgroundColor: this.categories.map(() => color().hexString())
    //     }
    //   ]
    // }, {
    //   responsive: false,
    //   maintainAspectRatio: false,
    //   plugins: {
    //     legend: {
    //       display: false
    //     }
    //   }
    // })
  }
}
</script>