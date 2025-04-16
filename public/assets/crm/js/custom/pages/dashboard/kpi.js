'use strict';
var TI_KPI = function () {
    var getOrCreateLegendList = (chart, id) => {
        const legendContainer = document.getElementById(id);
        let listContainer = legendContainer.querySelector('ul');

        if (!listContainer) {
          listContainer = document.createElement('ul');
          listContainer.style.display = 'flex';
          listContainer.style.flexDirection = 'column';
          listContainer.style.margin = 0;
          listContainer.style.padding = 0;

          legendContainer.appendChild(listContainer);
        }

        return listContainer;
      };
      var htmlLegendPlugin = {
        id: 'htmlLegend',
        afterUpdate(chart, args, options) {
          const ul = getOrCreateLegendList(chart, options.containerID);

          // Remove old legend items
          while (ul.firstChild) {
            ul.firstChild.remove();
          }

          // Reuse the built-in legendItems generator
          const items = chart.options.plugins.legend.labels.generateLabels(chart);

          items.forEach(item => {
            const li = document.createElement('li');
            li.style.alignItems = 'center';
            li.style.cursor = 'pointer';
            li.style.display = 'flex';
            li.style.flexDirection = 'row';
            li.style.marginLeft = '10px';
            li.style.marginBottom = '10px';
            li.className = 'fs-4';

            li.onclick = () => {
              const {type} = chart.config;
              if (type === 'pie' || type === 'doughnut') {
                // Pie and doughnut charts only have a single dataset and visibility is per item
                chart.toggleDataVisibility(item.index);
              } else {
                chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
              }
              chart.update();
            };

            // Color box
            const boxSpan = document.createElement('span');
            boxSpan.style.background = item.fillStyle;
            boxSpan.style.borderColor = item.strokeStyle;
            boxSpan.style.borderWidth = item.lineWidth + 'px';
            boxSpan.style.display = 'inline-block';
            boxSpan.style.flexShrink = 0;
            boxSpan.style.height = '20px';
            boxSpan.style.marginRight = '10px';
            boxSpan.style.width = '20px';
            boxSpan.style.borderRadius = '4px';

            // Text
            const textContainer = document.createElement('p');
            textContainer.style.color = item.fontColor;
            textContainer.style.margin = 0;
            textContainer.style.padding = 0;
            textContainer.style.textDecoration = item.hidden ? 'line-through' : '';

            const text = document.createTextNode(item.text);
            textContainer.appendChild(text);

            li.appendChild(boxSpan);
            li.appendChild(textContainer);
            ul.appendChild(li);
          });
        }
      }
    var initialChart = function() {
        var ctx = document.getElementById('ti_doughnut_chart_demo');
        var legend_container_id = ctx.getAttribute('data-legend-container');

        // Define colors
        var primaryColor = TI_Util.getCssVariableValue('--bs-primary');
        var dangerColor = TI_Util.getCssVariableValue('--bs-danger');
        var successColor = TI_Util.getCssVariableValue('--bs-success');
        var infoColor = TI_Util.getCssVariableValue('--bs-info');

        // Define fonts
        var fontFamily = TI_Util.getCssVariableValue('--bs-font-sans-serif');

        // Chart labels
        const labels = ['Đang liên hệ', 'Đang nộp hồ sơ', 'Sinh viên chính thức', 'Thí sinh từ chối'];

        // Chart data
        const data = {
            labels: labels,
            datasets: [{
                label: 'DEMO CHART',
                data: [
                    10,
                    20,
                    30,
                    40
                ],
                backgroundColor: [
                    primaryColor,
                    dangerColor,
                    successColor,
                    infoColor,
                ],
                hoverOffset: 4
              }]
        };

        // Chart config
        const config = {
            type: 'doughnut',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: false,
                    },
                    legend: {
                        position: 'right',
                        labels: {
                            font: {
                                size: 18
                            }
                        }
                    },
                    // ChartJs labels plugins: see https://github.com/DavideViolante/chartjs-plugin-labels/
                    labels: {
                        render: 'percentage',
                        fontColor: '#fff',
                        fontSize: 18,
                        textShadow: true,
                        arc: false,
                        precision: 0
                    }
                },
                cutout: '30%',
                responsive: true,
                maintainAspectRatio: false,
            },
            defaults:{
                global: {
                    defaultFont: fontFamily
                }
            }
        };

        if (legend_container_id) {
            config.options.plugins.legend.display = false;
            config.options.plugins.htmlLegend = {
              // ID of the container to put the legend in
              containerID: legend_container_id,
            };
            if (!Array.isArray(config.plugins)) {
              config.plugins = [];
            }
            config.plugins.push(htmlLegendPlugin);
          }
        // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
        return new Chart(ctx, config);
    }
    var initialChart9 = function() {
      var ctx = document.getElementById('ti_doughnut_chart_demo_9');
      var legend_container_id = ctx.getAttribute('data-legend-container');

      // Define colors
      var primaryColor = TI_Util.getCssVariableValue('--bs-primary');
      var dangerColor = TI_Util.getCssVariableValue('--bs-danger');
      var successColor = TI_Util.getCssVariableValue('--bs-success');
      var infoColor = TI_Util.getCssVariableValue('--bs-info');

      // Define fonts
      var fontFamily = TI_Util.getCssVariableValue('--bs-font-sans-serif');

      // Chart labels
      const labels = ['Đang liên hệ', 'Đang nộp hồ sơ', 'Sinh viên chính thức', 'Thí sinh từ chối'];

      // Chart data
      const data = {
          labels: labels,
          datasets: [{
              label: 'DEMO CHART',
              data: [
                  10,
                  20,
                  30,
                  40
              ],
              backgroundColor: [
                  primaryColor,
                  dangerColor,
                  successColor,
                  infoColor,
              ],
              hoverOffset: 4
            }]
      };

      // Chart config
      const config = {
          type: 'doughnut',
          data: data,
          options: {
              plugins: {
                  title: {
                      display: false,
                  },
                  legend: {
                      position: 'right',
                      labels: {
                          font: {
                              size: 18
                          }
                      }
                  },
                  // ChartJs labels plugins: see https://github.com/DavideViolante/chartjs-plugin-labels/
                  labels: {
                      render: 'percentage',
                      fontColor: '#fff',
                      fontSize: 18,
                      textShadow: true,
                      arc: false,
                      precision: 0
                  }
              },
              cutout: '30%',
              responsive: true,
              maintainAspectRatio: false,
          },
          defaults:{
              global: {
                  defaultFont: fontFamily
              }
          }
      };

      if (legend_container_id) {
          config.options.plugins.legend.display = false;
          config.options.plugins.htmlLegend = {
            // ID of the container to put the legend in
            containerID: legend_container_id,
          };
          if (!Array.isArray(config.plugins)) {
            config.plugins = [];
          }
          config.plugins.push(htmlLegendPlugin);
        }
      // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
      return new Chart(ctx, config);
  }

    return {
        init: function() {
            initialChart();
            initialChart9();
        }
    }
}();
// On document ready
TI_Util.onDOMContentLoaded(function () {
	TI_KPI.init();
});
//# sourceMappingURL=kpi.js.map
