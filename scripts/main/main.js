/*!
 * @package APPKARGO
 * @copyright Noobscript
 * @author algazasolution
 * @version 1.0
 * @access Public
 * @link /rab_frontend/scripts/main/main.js
 */

$(document).ready(function () {

    $.ajax({
        url: siteUrl('main/main/generate_chart'),
        method: "POST",
        dataType: 'JSON',
        success: function(data) {
            // console.log(data);
            var label = [];
            var value = [];
            var value2 = [];
            
            $("#total_pendapatan").html(data.total_ytd);
            $("#total_pengeluaran").html(data.total_pengeluaran_ytd);
            
            $.each(data.value, (idx, item) => {
                
                label.push(item.bulan);
                value.push(item.total);
                value2.push(item.total_pengeluaran);
            });


            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode      = 'index';
            var intersect = true;

            var ctx = document.getElementById('sales-chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [
                        {
                            label: 'Pendapatan',
                            backgroundColor: '#007bff',
                            borderColor: '#007bff',
                            data: value
                        },
                        {
                            label: 'Pengeluaran',
                            backgroundColor: '#ced4da',
                            borderColor    : '#ced4da',
                            data           : value2
                        }
                    ]
                },
                options: {
                    tooltipTemplate: "<%= addCommas(value) %>",
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : mode,
                        intersect: intersect,
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                
                                var val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];

                                val += '';
                                x = val.split('.');
                                x1 = x[0];
                                x2 = x.length > 1 ? '.' + x[1] : '';
                                var rgx = /(\d+)(\d{3})/;
                                while (rgx.test(x1)) {
                                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                                }
                                return x1 + x2;
                                }
                        }
                    },
                    hover              : {
                        mode     : mode,
                        intersect: intersect
                    },
                    legend             : {
                        display: false
                    },
                    scales             : {
                        yAxes: [{
                        // display: false,
                            gridLines: {
                            display      : true,
                            lineWidth    : '4px',
                            color        : 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                            },
                            ticks    : $.extend({
                            beginAtZero: true,

                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                              if (value >= 1000) {
                                value /= 1000
                                value += 'k'
                              }
                              return '$' + value
                            }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display  : true,
                            gridLines: {
                            display: false
                            },
                            ticks    : ticksStyle
                        }]
                    }
                }
            });
        }
    });

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
  //   var ticksStyle = {
  //       fontColor: '#495057',
  //       fontStyle: 'bold'
  //     }

  //   var mode      = 'index'
  //   var intersect = true
  //   var $salesChart = $('#sales-chart')

  //   var salesChart  = new Chart($salesChart, {
  //   type   : 'bar',
  //   data   : {
  //     labels  : ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
  //     datasets: [
  //       {
  //         backgroundColor: '#007bff',
  //         borderColor    : '#007bff',
  //         data           : [1000, 2000, 3000, 2500, 2700, 2500, 3000]
  //       },
  //       {
  //         backgroundColor: '#ced4da',
  //         borderColor    : '#ced4da',
  //         data           : [700, 1700, 2700, 2000, 1800, 1500, 2000]
  //       }
  //     ]
  //   },
  //   options: {
  //     maintainAspectRatio: false,
  //     tooltips           : {
  //       mode     : mode,
  //       intersect: intersect
  //     },
  //     hover              : {
  //       mode     : mode,
  //       intersect: intersect
  //     },
  //     legend             : {
  //       display: false
  //     },
  //     scales             : {
  //       yAxes: [{
  //         // display: false,
  //         gridLines: {
  //           display      : true,
  //           lineWidth    : '4px',
  //           color        : 'rgba(0, 0, 0, .2)',
  //           zeroLineColor: 'transparent'
  //         },
  //         ticks    : $.extend({
  //           beginAtZero: true,

  //           // Include a dollar sign in the ticks
  //           callback: function (value, index, values) {
  //             if (value >= 1000) {
  //               value /= 1000
  //               value += 'k'
  //             }
  //             return '$' + value
  //           }
  //         }, ticksStyle)
  //       }],
  //       xAxes: [{
  //         display  : true,
  //         gridLines: {
  //           display: false
  //         },
  //         ticks    : ticksStyle
  //       }]
  //     }
  //   }
  // })
});