@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_start')

<div class="{{ $widget['class'] ?? 'alert alert-primary' }}" role="alert">
	@if (isset($widget['content']))
	<div class="h5 font-weight-bold text-info ml-4">{!! $widget['content'] !!}</div>
	@endif 
    <div id="chart"></div>    
</div>

@push('after_styles')
<style> 
</style>
@endpush

@push('after_scripts')
<script>
var options = {
  chart: {
    height: 350,
    type: "line",
    stacked: false,
    animations: {
        enabled: true,
        easing: 'linear',
        dynamicAnimation: {
             speed: 1000
        }
    },
    toolbar: {
        show: true
    },
    zoom: {
        enabled: true
    }          
  },
  dataLabels: {
    enabled: false
  },
  colors: ["#FF1654", "#247BA0"],
  series: [
    {
      name: "Uplink",
      data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6, 1.5, 2.5, 2.8, 3.8, 4.6]
    },
    {
      name: "Downlink",
      data: [20, 29, 37, 36, 44, 45, 50, 58, 36, 44, 45, 50, 58]
    }
  ],
  stroke: {
    width: [4, 4]
  },
  plotOptions: {
    bar: {
      columnWidth: "20%"
    }
  },
  grid: {
    show: true,
    position: 'back',
    borderColor: '#e0e0e0',
    xaxis: {
        lines: {
            show: true
        }
    },   
    yaxis: {
        lines: {
            show: true
        }
    }    
  },
  xaxis: {
    
    categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021],
    lines: {
        show: true,
      }, 
      
  },
  yaxis: [
    {      
      axisTicks: {
        show: true
      },
      labels: {
        style: {
          colors: "#FF1654"
        }
      },
      title: {
        text: "Uplink",
        style: {
          color: "#FF1654"
        }
      }
    },
    {
      opposite: true,
      axisTicks: {
        show: true
      },
      labels: {
        style: {
          colors: "#247BA0"
        }
      },
      title: {
        text: "Downlink",
        style: {
          color: "#247BA0"
        }
      }
    }
  ],
  tooltip: {
    shared: false,
    intersect: true,
    x: {
      show: false
    }
  },
  legend: {
    horizontalAlign: "left",
    offsetX: 40
  },
  responsive: [
    {
      breakpoint: 1000,
      options: {
        plotOptions: {
            bar: {
            columnWidth: "10%"
            }
        },
        yaxis: [
            {
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                    color: "#FF1654"
                },
                labels: {
                    style: {
                    colors: "#FF1654"
                    }
                },
            },
        ],        
        legend: {
            horizontalAlign: "left",
            offsetX: 20
        }
      }
    }
  ]  
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

</script>
@endpush
@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_end')