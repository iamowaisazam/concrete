<template>
  <canvas id="line-chart" width="400" height="200"></canvas>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
  name: 'LineChart',
  props: {
    chartData: Object,
  },
  data() {
    return {
      chart: null,
    };
  },
  mounted() {
    this.renderChart();
  },
  watch: {
    chartData() {
      this.renderChart();
    },
  },
  methods: {
    renderChart() {
      if (!this.chartData) return;
      const ctx = document.getElementById('line-chart').getContext('2d');
      if (this.chart) {
        this.chart.destroy();
      }
      this.chart = new Chart(ctx, {
        type: 'line',
        data: this.chartData,
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    },
  },
};
</script>