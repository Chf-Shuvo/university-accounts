@extends('backend.layout.master')

@section('content')
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 mb-20">
      <div class="pd-20 card-box height-100-p">
        <h4 class="text-info p-2 text-center">Important Dates</h4>
        <table class="table table-striped">
          <tbody>
            <tr>
              <td>Current Period:</td>
              <td>From <b>{{ Carbon\Carbon::parse(Calculation::start_date())->format('d M Y') }}</b> To <b>
                  {{ Carbon\Carbon::parse(Calculation::end_date())->format('d M Y') }}</b>
              </td>
            </tr>
            <tr>
              <td>Current Date:</td>
              <td><b>{{ Carbon\Carbon::now()->format('d M Y') }}</b></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 mb-20">
      <div class="pd-20 card-box height-100-p">
        <h4 class="text-info text-center p-2"><u>Company Details</u></h4>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name of The Company</th>
              <th>Last Date of Entry</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <h5>{{ auth()->user()->company_name }}</h5>
              </td>
              <td>
                <h5>{{ Carbon::parse(auth()->user()->company_last_entry_date)->format('d M Y') }}</h5>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    {{-- Charts --}}
    <div class="col-md-8 col-12 mb-3">
      <div class="card-box pd-20 height-100-p mb-30">
        <h5 class="text-info p-3"><u>Stats of Monthly Income:</u></h5>
        <div id="chart3"></div>
      </div>
    </div>
    <div class="col-md-4 col-12 mb-3">
      <div class="card-box pd-20 height-100-p mb-30">
        <h5 class="text-info p-3"><u>Monthly Collection From Department (Aug, 2022):</u></h5>
        <div id="chart8"></div>
      </div>
    </div>
    <div class="col-md-12 col-12">
      <div class="card-box pd-20 height-100-p mb-30">
        <h5 class="text-info p-3"><u>Yearly Collection:</u></h5>
        <div id="chart10"></div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script src="{{asset('backend/src/plugins/apexcharts/apexcharts.min.js')}}"></script>
  <script>
    var options3 = {
      series: [{
        name: 'Customer Joined',
        data: [0, 0, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0]
      }],
      chart: {
        type: 'bar',
        height: 350,
        toolbar: {
          show: false,
        }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '40%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      },
      yaxis: {
        title: {
          text: 'Single Unit'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val
          }
        }
      }
    };
    var chart = new ApexCharts(document.querySelector("#chart3"), options3);
    chart.render();
  </script>
  <script>
    var options8 = {
      series: [0, 7, 0],
      chart: {
        type: 'donut',
      },
      labels: ['CSE', 'EEE', 'CE'],
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };
    var chart = new ApexCharts(document.querySelector("#chart8"), options8);
    chart.render();
  </script>
  <script>
    var options = {
      series: [{
        name: 'Amount',
        data: [0, 0, 0, 932, 0, 0, 1234, 0, 0, 0, 0, 0]
      }],
      chart: {
        height: 350,
        type: 'area'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      },
      yaxis: {
        title: {
          text: 'In Currency: '
        }
      },
    };

    var chart = new ApexCharts(document.querySelector("#chart10"), options);
    chart.render();
  </script>
@endpush
