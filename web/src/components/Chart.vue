<template>
  <div>
    <canvas ref="canvas"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js/auto'

export default {
  props: {
    height: {
      type: String,
    }
  },
  data() {
    return {
      chart: null
    }
  },
  methods: {
    renderChart(chartType, data, options) {
      if (this.chart) {
        this._chart.destroy()
      }
      this.chart = new Chart(
          this.$refs.canvas.getContext('2d'), {
            type: chartType,
            data: data,
            options: options
          }
      )

      if (this.height) {
        this.chart.canvas.parentNode.style.height = this.height;
        this.chart.resize()
      }
    }
  }
}
</script>