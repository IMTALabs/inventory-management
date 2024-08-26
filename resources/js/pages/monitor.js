class MonitorScript {
  static initMonitorScript() {
    // Set Global Chart.js configuration
    Chart.defaults.color = "#818d96";
    Chart.defaults.font.weight = "600";
    Chart.defaults.scale.grid.color = "rgba(0, 0, 0, .05)";
    Chart.defaults.scale.grid.zeroLineColor = "rgba(0, 0, 0, .1)";
    Chart.defaults.scale.beginAtZero = true;
    Chart.defaults.elements.line.borderWidth = 2;
    Chart.defaults.elements.point.radius = 4;
    Chart.defaults.elements.point.hoverRadius = 6;
    Chart.defaults.plugins.tooltip.radius = 3;
    Chart.defaults.plugins.legend.labels.boxWidth = 15;

    let charts = {};
    if (metrics.length > 0) {
      metrics.forEach((metric) => {
        let chartLinesCon = document.getElementById(`js-chartjs-${ metric }`);

        if (chartLinesCon !== null) {
          charts[metric] = new Chart(chartLinesCon, {
            type: "line",
            data: chartData[metric],
            options: { responsive: true, maintainAspectRatio: false, tension: .4 }
          });
        }
      });
    }

    setInterval(() => {
      jQuery.ajax({
        url: `/monitor/${ currentEquipment.id }/fetch`,
        type: "GET",
        success: (response) => {
          for (const key in response) {
            const data = response[key];
            chartData[key].labels = data.map((item) => item.created_at);
            chartData[key].datasets[0].data = data.map((item) => item.metric_value);
            charts[key].update();
          }
        }
      });
    }, 5000);
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initMonitorScript();
  }
}

// Initialize when page loads
One.onLoad(() => MonitorScript.init());
