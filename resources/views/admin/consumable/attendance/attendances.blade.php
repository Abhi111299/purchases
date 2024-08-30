@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Attendances")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Attendances</h4>
      <div>
        <a href="{{ url("admin/attendance_download_excel?staff_id=&from_date=&to_date=") }}" id="excel_download"
          class="btn btn-white"><i class="fa fa-download"></i> Download</a>
      </div>
    </div>
    <div class="d-flex justify-content-center justify-content-lg-end">
      <div class="col-xs-10">
        <div class="row justify-content-end row-cols-1 row-cols-md-3">
          <div class="col mb-3">
            <div class="form-group">
              <select class="form-control selectbox_staff" id="staff_id" name="staff_id" onchange="filter_options()">
                <option value="">Staff</option>
                @foreach ($staffs as $staff)
                  <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname . " " . $staff->staff_lname }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col mb-3">
            <div class="form-group">
              <input type="text" class="form-control" id="from_date" name="from_date" placeholder="From Date"
                onchange="filter_options()">
            </div>
          </div>
          <div class="col mb-3">
            <div class="form-group">
              <input type="text" class="form-control" id="to_date" name="to_date" placeholder="To Date"
                onchange="filter_options()">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <div class="table-responsive">
              <table id="attendance_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Staff</th>
                    <th>Date</th>
                    <th>Attendance</th>
                    <th>Notes</th>
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
@endsection
@section("custom_script")
  <script>
    var dataTable = $('#attendance_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_attendances") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";
          var staff_id = $('#staff_id').val();
          var from_date = $('#from_date').val();
          var to_date = $('#to_date').val();

          data._token = token;
          data.staff_id = staff_id;
          data.from_date = from_date;
          data.to_date = to_date;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'staff_name'
        },
        {
          data: 'attendance_date'
        },
        {
          data: 'type'
        },
        {
          data: 'attendance_notes'
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
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();

      var excel_url = window.location.origin + '/admin/attendance_download_excel?staff_id=' + staff_id + '&from_date=' +
        from_date + '&to_date=' + to_date;

      $("#excel_download").attr("href", excel_url);

      dataTable.draw();
    }

    $('#from_date').datepicker({
      format: 'dd-mm-yyyy',
      todayHighlight: true,
      autoclose: true
    });

    $('#to_date').datepicker({
      format: 'dd-mm-yyyy',
      todayHighlight: true,
      autoclose: true
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

    $('.selectbox_staff').select2({
      theme: "bootstrap",
      placeholder: "Staff"
    });
  </script>
@endsection
