@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Timesheets")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Timesheets</h4>
      <div>
        <a href="{{ url("staff/add_timesheet") }}" class="btn btn-white"><i class="fa fa-plus"></i> Add
          Timesheet</a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <div class="table-responsive">
              <table id="timesheet_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Start Time</th>
                    <th>Finish Time</th>
                    <th>Client</th>
                    <th>Location</th>
                    <th>Description</th>
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
    var dataTable = $('#timesheet_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 20,
      'ajax': {
        type: 'POST',
        url: "{{ url("staff/get_timesheets") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";

          data._token = token;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'timesheet_date'
        },
        {
          data: 'status'
        },
        {
          data: 'timesheet_start'
        },
        {
          data: 'timesheet_end'
        },
        {
          data: 'customer_name'
        },
        {
          data: 'location_name'
        },
        {
          data: 'timesheet_desc'
        }
      ]
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
  </script>
@endsection
