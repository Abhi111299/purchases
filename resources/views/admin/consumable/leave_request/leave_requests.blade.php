@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Leave Requests")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-3">
      <h4 class="text-white">Leave Requests</h4>
      <div>
        <a href="{{ url("admin/leave_request_download_excel?staff_id=") }}" id="excel_download" class="btn btn-white"><i
            class="fa fa-download"></i> Download</a>
      </div>
    </div>
    <div class="d-flex justify-content-center justify-content-lg-end mb-3">
      <div class="col-xs-10 col-md-6 col-lg-4">
        <select class="form-control selectbox_staff" id="staff_id" name="staff_id" onchange="filter_options()">
          <option value="">Staff</option>
          @foreach ($staffs as $staff)
            <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname . " " . $staff->staff_lname }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <div class="table-responsive">
              <table id="leave_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Staff</th>
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
      </div>
    </div>
  </section>
  <div id="LeaveModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div>
  </div>
@endsection
@section("custom_script")
  <script>
    var dataTable = $('#leave_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_leave_requests") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";
          var staff_id = $('#staff_id').val();

          data._token = token;
          data.staff_id = staff_id;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'staff_name'
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

    function filter_options() {
      var staff_id = $('#staff_id').val();

      var excel_url = window.location.origin + '/admin/leave_request_download_excel?staff_id=' + staff_id;

      $("#excel_download").attr("href", excel_url);

      dataTable.draw();
    }

    function leave_status(leave_id) {
      var csrf = "{{ csrf_token() }}";

      $.ajax({
        url: "{{ url("admin/leave_requests_status") }}",
        type: "post",
        data: "leave_id=" + leave_id + '&_token=' + csrf,
        success: function(data) {

          $(".modal-content").html(data);
          $('#LeaveModal').modal('show');
        }
      });
    }

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

    $('.selectbox_staff').select2({
      theme: "bootstrap",
      placeholder: "Staff"
    });
  </script>
@endsection
