'use strict';
var TI_Overview = function () {
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
      var ctx = document.getElementById('ti_overview_chart_demo');
      // Get table above current element
      var table = ctx.previousElementSibling;
      var lastRow = table.rows[ table.rows.length - 1 ];
      var lastRowHeight = lastRow.offsetHeight;

      ctx.style.bottom = lastRowHeight + 'px';
      // Define colors
      var chartColor = TI_Util.getCssVariableValue('--bs-text-gray-300');

      if (ctx.getAttribute('data-color-variable')) {
          chartColor = TI_Util.getCssVariableValue(ctx.getAttribute('data-color-variable'));
      }

      if (ctx.getAttribute('data-color')) {
          chartColor = ctx.getAttribute('data-color');
      }


      // Chart labels
      const labels = ['1', '2', '3', '4', '5', '6', '7', '8'];

      // Chart data
      const data = {
          labels: labels,
          datasets: [{
              label: 'dataset',
              data: [
                  90,
                  20,
                  30,
                  40,
                  90,
                  20,
                  30,
                  40
              ],
              borderColor: chartColor,

              fill: true,
              borderWidth: 0,
              lineTension: 0.4,
              backgroundColor: [
                  chartColor
              ],
              hoverOffset: 0
            }]
      };

      const config = {
          type: 'line',
          data: data,
          options: {
            animation: {
              onComplete: function() {


              }
            },
            responsive: true,
            plugins: {
              tooltip: {
                enabled: false
              },
              legend: {
                display: false
              },
              filler: {
                propagate: false,
              },
              title: {
                display: false,
              }
            },
            scales: {
              x: {
                display: false,

                },
                y: {
                    display: false
              }
            },

            elements: {
                point:{
                    radius: 0
                }
            },
            interaction: {
              intersect: false,
            }
          },
        };


      // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
      return new Chart(ctx, config);
  }

  var initialChart2 = function() {
    var ctx = document.getElementById('ti_overview_chart_demo_2');

    var color1 = TI_Util.getCssVariableValue('--bs-text-gray-400');
    var color2 = TI_Util.getCssVariableValue('--bs-text-success');

    const labels = [
      'Khoa đào tạo sau đại học',
      'Khoa Công nghệ Thông tin',
      'Khoa kinh tế và Quản lý công',
      'Khoa Tài chính - Ngân hàng',
      'Khoa Khoa học cơ bản',
      'Khoa Đào tạo Đặc biệt',
      'Khoa Kế toán - Kiểm toán',
      'Khoa Ngoại ngữ',
      'Khoa Xây dựng',
      'Khoa Công nghệ Sinh học',
      'Khoa Luật',
      'Khoa XHH - CTXH - ĐNA'
    ];
    // Chart data
    const data = {
      labels: labels,
      datasets: [
        {
          label: 'Học phí dự kiến',
          data: [
              90,
              20,
              30,
              40,
              10,
              20,
              30,
              40,
              30,
              20,
              30,
              40
          ],
          backgroundColor: color1
        },
        {
          label: 'Học phí thu về',
          data: [
            60,
            50,
            30,
            70,
            20,
            10,
            70,
            60,
            30,
            60,
            20,
            90
          ],
          backgroundColor: color2
        }
      ]
    };
    const config = {
      type: 'bar',
      data: data,
      plugins: [{
        id: "htmlLegend",
        afterUpdate: function(chart, agrs, options) {
          const legendContainer = document.getElementById(options.containerID);
          // Remove old legend
          legendContainer.innerHTML = '';
          // Reuse the built-in legendItems generator
          const items = chart.options.plugins.legend.labels.generateLabels(chart);

          items.forEach(function(item) {
            const wrapperDiv = document.createElement('div');
            wrapperDiv.className = 'd-none d-md-flex align-items-center pe-4';
            const formCheckDiv = document.createElement('div');
            formCheckDiv.className = 'form-check form-switch form-check-custom form-switch-sm';
            const input = document.createElement('input');
            input.className = 'form-check-input';
            input.type = 'checkbox';
            // input.checked = 'checked';
            input.checked = chart.isDatasetVisible(item.datasetIndex);
            input.id = 'flexSwitchCheckChecked_' + item.datasetIndex;
            input.onchange = (elm, event) => {
              const {type} = chart.config;
              if (type === 'pie' || type === 'doughnut') {
                // Pie and doughnut charts only have a single dataset and visibility is per item
                chart.toggleDataVisibility(item.index);
              } else {
                chart.setDatasetVisibility(item.datasetIndex, !chart.isDatasetVisible(item.datasetIndex));
              }

              chart.update();
            };
            const label = document.createElement('label');
            label.className = 'form-check-label';
            label.for = 'flexSwitchCheckChecked' + item.datasetIndex;
            const text = document.createTextNode(item.text);
            label.style.color = item.fillStyle;
            label.appendChild(text);
            formCheckDiv.appendChild(input);
            formCheckDiv.appendChild(label);
            wrapperDiv.appendChild(formCheckDiv);

            legendContainer.appendChild(wrapperDiv);
          });
        }
      }],
      options: {
        maintainAspectRatio: false,
        indexAxis: 'y',
        // Elements options apply to all of the options unless overridden in a dataset
        // In this case, we are setting the border of each horizontal bar to be 2px wide
        elements: {
          bar: {
            borderWidth: 0,
          }
        },
        layout: {
          padding: {
              right: 20
          }
        },
        responsive: true,
        plugins: {
          legend: {
            display: false
          },
          title: {
            display: false
          },
          // ChartJs labels plugins: see https://github.com/DavideViolante/chartjs-plugin-labels/
          labels: {
            // render: function(args) {
            //     return args.value.label;
            // },
            render: 'value',
            // fontSize: 12,
            arc: false,
            precision: 0,
            // outsidePadding: -18,
            textMargin: -6,
            textHorizontalMargin: 12
          },
          htmlLegend: {
            containerID: 'ti_overview_chart_legend_2'
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            },
            title: {
              display: true,
              text: '(Triệu VND)',
              margin: {top: 0, left: 0, right: '80%', bottom: 0}
            }
            },
        }
      },
    };
    // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
    return new Chart(ctx, config);
  }

  var initialChart3 = function() {
    var ctx = document.getElementById('ti_overview_chart_demo_3');

    var color1 = TI_Util.getCssVariableValue('--bs-text-secondary');
    var color2 = TI_Util.getCssVariableValue('--bs-text-danger');
    var color3 = TI_Util.getCssVariableValue('--bs-text-warning');
    var color4 = TI_Util.getCssVariableValue('--bs-text-success');
    var color5 = TI_Util.getCssVariableValue('--bs-text-primary');

    const labels = [
      'Facebook',
      'Website',
      'Landing page',
      'Tờ rơi',
      'Youtube'
    ];
    // Chart data
    const data = {
      labels: labels,
      datasets: [
        {
          label: 'data1',
          data: [
              758,
              580,
              975,
              430,
              590
          ],
          backgroundColor: [
            color1, color2, color3, color4, color5
          ]
        }
      ]
    };
    const config = {
      type: 'bar',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        elements: {
          bar: {
            borderWidth: 2,
          }
        },
        plugins: {
          legend: {
            display: false
          },
          title: {
            display: false
          },
          // ChartJs labels plugins: see https://github.com/DavideViolante/chartjs-plugin-labels/
          labels: {
            render: 'value',
            precision: 0,
            // textMargin: -6,
            // textHorizontalMargin: 12
          }
        },
        scales: {
          y: {

            title: {
              display: true,
              text: '(Người)'
            }
            },
          x: {
            grid: {
              display: false
            },
          }
        }
      },
    };
    // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
    return new Chart(ctx, config);
  }

  var initialChart4 = function() {
    var ctx = document.getElementById('ti_overview_chart_demo_4');

    var color1 = TI_Util.getCssVariableValue('--bs-text-primary');

    const labels = [
      '15/3',
      '16/3',
      '17/3',
      '18/3',
      '19/3'
    ];
    // Chart data
    const data = {
      labels: labels,
      datasets: [
        {
          label: 'data1',
          data: [
              152,
              163,
              336,
              631,
              503,
              845,
              804,
          ],
          backgroundColor: color1

        }
      ]
    };
    const config = {
      type: 'bar',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        elements: {
          bar: {
            borderWidth: 2,
          }
        },
        plugins: {
          legend: {
            display: false
          },
          title: {
            display: false
          },
          // ChartJs labels plugins: see https://github.com/DavideViolante/chartjs-plugin-labels/
          labels: {
            render: 'value',
            precision: 0,
            // textMargin: -6,
            // textHorizontalMargin: 12
          }
        },
        scales: {
          y: {

            title: {
              display: true,
              text: '(Người)'
            }
            },
          x: {
            grid: {
              display: false
            },
          }
        }
      },
    };
    // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/
    return new Chart(ctx, config);
  }
  var initialChart5 = function() {
    var ctx = document.getElementById('ti_doughnut_chart_demo_5');
    var legend_container_id = ctx.getAttribute('data-legend-container');

    // Define fonts
    var fontFamily = TI_Util.getCssVariableValue('--bs-font-sans-serif');

    // Chart labels
    const labels = [
      'Khoa học công nghệ - Thông tin',
      'Khoa Tài chính - Ngân hàng',
      'Khoa Kế toán - Kiểm toán',
      'Khoa Ngoại ngữ',
      'Khoa Luật'];

    // Chart data
    const data = {
        labels: labels,
        datasets: [{
            label: 'Chart 5',
            data: [
                20,
                10,
                28,
                30,
                12
            ],
            backgroundColor: [
                '#034EA2',
                '#387EC1',
                '#6DABE5',
                '#B8D2EC',
                '#7E7E7E'
            ],
            hoverOffset: 4
          }]
    };
    const config = {
      type: 'doughnut',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
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
                // render: function(args) {
                //     return args.value.label;
                // },
                render: 'percentage',
                fontColor: '#fff',
                fontSize: 18,
                textShadow: true,
                arc: false,
                precision: 0
            }
        },
        cutout: '30%',
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

  var initialChart6 = function() {
    var ctx = document.getElementById('ti_doughnut_chart_demo_6');
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
    //   initialChart();
      initialChart2();
      initialChart3();
    //   initialChart4();
    //   initialChart5();
      initialChart6();
    }
  }
}();
// On document ready
TI_Util.onDOMContentLoaded(function () {
	TI_Overview.init();
});
//# sourceMappingURL=kpi-detail.js.map
