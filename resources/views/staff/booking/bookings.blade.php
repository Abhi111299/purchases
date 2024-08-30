@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Jobs")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Jobs</h4>
    </div>
  </section>
  <div class="d-flex justify-content-center justify-content-lg-end">
    <div class="col-xs-10">
      <div class="row justify-content-end row-cols-1 row-cols-md-3">
        <div class="col mb-3">
          <div class="form-group">
            <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Start Date"
              onchange="filter_options()" autocomplete="off">
          </div>
        </div>
        <div class="col mb-3">
          <div class="form-group">
            <input type="text" class="form-control" id="end_date" name="end_date" placeholder="End Date"
              onchange="filter_options()" autocomplete="off">
          </div>
        </div>
        <div class="col mb-3">
          <div class="form-group">
            <select class="form-control selectbox_filter" id="branch_id" name="branch_id" onchange="filter_options()">
              <option value="">Branch Location</option>
              @foreach ($locations as $location)
                <option value="{{ $location->location_id }}">{{ $location->location_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">

          <div class="card-body">

            <div class="table-responsive" style="margin-top: 10px">
              <table id="booking_table" class="table " style="width: 100%">
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
                   
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section("custom_script")
  <script>
    var dataTable = $('#booking_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 20,
      'ajax': {
        type: 'POST',
        url: "{{ url("staff/get_bookings") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
          var branch_id = $('#branch_id').val();

          data._token = token;
          data.start_date = start_date;
          data.end_date = end_date;
          data.branch = branch_id;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'booking_job_id'
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
        
      ]
    });

    function filter_options() {
      dataTable.draw();
    }

    $(function() {

      $('#start_date').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true
      });

      $('#end_date').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true
      });

    });

    function confirm_msg(ev) {
      ev.preventDefault();

      var urlToRedirect = ev.currentTarget.getAttribute('href');

      swal({
          title: "Are you sure?",
          text: 'You want to change status!',
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willChange) => {

          if (willChange) {
            window.location.href = urlToRedirect;
          }

        });
    }

    $('.selectbox_filter').select2({
      theme: "bootstrap"
    });
  </script>
@endsection
