@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Dashboard")
@section("contents")
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <section class="content-header">
    <div class="header-title">
      <h1 class="text-white">Dashboard</h1>
    </div>
  </section>
  <section class="content">
    @if (in_array("5", Request()->modules))
      <div class="card">
        <div class="card-header bg-white">
          <div class="d-flex justify-content-between fw-bold">
            <div>Booking stats</div>
            <div>Total Bookings: {{ $total_bookings }}</div>
          </div>
        </div>
        <div class="card-body">
          <div class="row row-cols-1 row-cols-md-2 align-items-center">
            <div class="col">
              <div id="radial-bar-chart"></div>
            </div>
            <div class="col">
              <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold d-flex align-items-center">
                      <div style="width:12px; height:12px; background:#FF4560" class="d-block rounded-circle me-2"></div>
                      Pending Bookings
                    </div>
                  </div>
                  <span class="badge text-bg-primary rounded-pill">{{ $pending_bookings }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold d-flex align-items-center">
                      <div style="width:12px; height:12px; background:#775DD0" class="d-block rounded-circle me-2"></div>
                      Cancelled Bookings
                    </div>
                  </div>
                  <span class="badge text-bg-primary rounded-pill">{{ $cancelled_bookings }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold d-flex align-items-center">
                      <div style="width:12px; height:12px; background:#00E396" class="d-block rounded-circle me-2"></div>
                      Incomplete Bookings
                    </div>
                  </div>
                  <span class="badge text-bg-primary rounded-pill">{{ $incomplete_bookings }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold d-flex align-items-center">
                      <div style="width:12px; height:12px; background:#FEB019" class="d-block rounded-circle me-2"></div>
                      Report Bookings
                    </div>
                  </div>
                  <span class="badge text-bg-primary rounded-pill">{{ $report_bookings }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold d-flex align-items-center">
                      <div style="width:12px; height:12px; background:#008FFB" class="d-block rounded-circle me-2"></div>
                      Completed Bookings
                    </div>
                  </div>
                  <span class="badge text-bg-primary rounded-pill">{{ $completed_bookings }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold d-flex align-items-center">
                      <div style="width:12px; height:12px; background:#FF4560" class="d-block rounded-circle me-2"></div>
                      Reschedule Bookings
                    </div>
                  </div>
                  <span class="badge text-bg-primary rounded-pill">{{ $rescheduled_bookings }}</span>
                </li>

              </ul>
            </div>
          </div>
        </div>
      </div>


      <div class="card mt-3">
        <div class="card-body">
          <div id="line-chart"></div>

        </div>
      </div>


      <div class="row">
        <div class="col-sm-12">
          <div class="panel-bd">
            <div class="d-flex justify-content-between py-3">
              <div>
                <h4>Today Jobs</h4>
              </div>
              <div>
                <a href="{{ url("admin/add_booking") }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add
                  Job</a>
              </div>
            </div>



            <div class="card card-body">
              <div class="table-responsive">
                <table id="today_schdule_table" class="table" style="width: 100%">
                  <thead>
                    <tr class="info">
                      <th>#</th>
                      <th>Job Card No</th>
                      <th>Service</th>
                      <th>Client</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Activities</th>
                      <th>Technicians</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table-group-divider">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- <div class="col-sm-6">
          <div class="card panel-bd">
            <div class="card-heading">
              <div class="btn-group" id="buttonexport">
                <a href="javascript:void(0)">
                  <h4>Jobs Count</h4>
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="customer_table" class="table " style="width: 100%">
                  <thead>
                    <tr class="info">
                      <th>Status</th>
                      <th>Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Pending</td>
                      <td>{{ $pending_bookings }}</td>
                    </tr>
                    <tr>
                      <td>Cancelled</td>
                      <td>{{ $cancelled_bookings }}</td>
                    </tr>
                    <tr>
                      <td>Incomplete</td>
                      <td>{{ $incomplete_bookings }}</td>
                    </tr>
                    <tr>
                      <td>Report Pending</td>
                      <td>{{ $report_bookings }}</td>
                    </tr>
                    <tr>
                      <td>Completed</td>
                      <td>{{ $completed_bookings }}</td>
                    </tr>
                    <tr>
                      <td>Rescheduled</td>
                      <td>{{ $rescheduled_bookings }}</td>
                    </tr>
                    <tr>
                      <td>Total</td>
                      <td>{{ $total_bookings }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div> --}}
      </div>
    @endif
  </section>
  <div id="bookingModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content bg-white">
      </div>
    </div>
  </div>
@endsection
@section("custom_script")
  <script>
    var dataTable = $('#today_schdule_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_today_bookings") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";
          data._token = token;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'booking_job_id',
        },
        {
          data: 'service_name'
        },
        {
          data: 'customer_name'
        },
        {
          data: 'booking_start'
        },
        {
          data: 'booking_end'
        },
        {
          data: 'activities'
        },
        {
          data: 'technicians'
        },
        {
          data: 'status'
        },
        {
          data: 'action',
          orderable: false,
          searchable: false
        }
      ]
    });

    function booking_status(booking_id) {
      var csrf = "{{ csrf_token() }}";

      $.ajax({
        url: "{{ url("admin/booking_status") }}",
        type: "post",
        data: "booking_id=" + booking_id + '&_token=' + csrf,
        success: function(data) {

          $(".modal-content").html(data);
          $('#bookingModal').modal('show');
        }
      });
    }
  </script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var pendingBookings = {{ $pending_bookings }};
      var cancelledBookings = {{ $cancelled_bookings }};
      var incompleteBookings = {{ $incomplete_bookings }};
      var reportBookings = {{ $report_bookings }};
      var completedBookings = {{ $completed_bookings }};
      var rescheduledBookings = {{ $rescheduled_bookings }};
      var totalBookings = {{ $total_bookings }};

      var seriesData = [
        Math.round((pendingBookings / totalBookings) * 100),
        Math.round((cancelledBookings / totalBookings) * 100),
        Math.round((incompleteBookings / totalBookings) * 100),
        Math.round((reportBookings / totalBookings) * 100),
        Math.round((completedBookings / totalBookings) * 100),
        Math.round((rescheduledBookings / totalBookings) * 100)
      ];

      var options = {
        series: seriesData,
        chart: {
          height: 350,
          type: 'radialBar'
        },
        plotOptions: {
          radialBar: {
            hollow: {
              size: '20%'
            },
            track: {
              background: 'transparent',
              strokeWidth: '100%',
              margin: 5, // margin is in pixels
              dropShadow: {
                enabled: false,
                top: 2,
                left: 0,
                blur: 4,
                opacity: 0.15
              }
            },
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '35px',
              },
              total: {
                show: true,
                label: 'Total',
                formatter: function(w) {
                  return totalBookings;
                }
              }
            }
          }
        },
        labels: ['Pending', 'Cancelled', 'Incomplete', 'Report Pending', 'Completed', 'Rescheduled'],
        colors: ['#FF4560', '#775DD0', '#00E396', '#FEB019', '#008FFB', '#FF4560']
      };

      var chart = new ApexCharts(document.querySelector("#radial-bar-chart"), options);
      chart.render();
    });
  </script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var data = @json($month_wise);

      // Extract months and totals from data
      var months = data.map(function(item) {
        return item.month;
      });

      var totals = data.map(function(item) {
        return item.total;
      });

      var options = {
        series: [{
          name: 'Total Bookings',
          data: totals
        }],
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        title: {
          text: 'Monthly Bookings',
          align: 'left'
        },
        grid: {
          strokeDashArray: 5,
          xaxis: {
            lines: {
              show: true,

            }
          },
          yaxis: {
            lines: {
              show: false,
              dashArray: 1 // Dashed horizontal lines
            }
          }
        },
        xaxis: {
          categories: months
        }
      };

      var chart = new ApexCharts(document.querySelector("#line-chart"), options);
      chart.render();
    });
  </script>



@endsection
