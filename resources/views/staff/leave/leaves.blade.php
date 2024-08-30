@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Leaves")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Leaves</h4>
      <div>
        <a href="{{ url("staff/add_leave") }}" class="btn btn-white"><i class="fa fa-plus"></i> Add
          Leave</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <div class="table-responsive">
          <table id="leave_table" class="table " style="width: 100%">
            <thead>
              <tr class="info">
                <th>#</th>
                <th>Type</th>
                <th>Apply Date</th>
                <th>Reason</th>
                <th>Start Date</th>
                <th>Return to Work</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
@endsection
@section("custom_script")
  <script>
    var dataTable = $('#leave_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 20,
      'ajax': {
        type: 'POST',
        url: "{{ url("staff/get_leaves") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";

          data._token = token;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'type'
        },
        {
          data: 'apply_date'
        },
        {
          data: 'leave_reason'
        },
        {
          data: 'start_date'
        },
        {
          data: 'return_date'
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
