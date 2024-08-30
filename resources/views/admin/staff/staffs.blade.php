@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Staffs")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-black">Staffs</h4>
      <div>
        <a href="{{ url("admin/add_staff") }}" class="btn btn-white"><i class="fa fa-plus"></i> Add
          Staff</a>
      </div>
    </div>
    <div class="d-flex justify-content-center justify-content-lg-end mb-3">
      <div class="col-xs-10 col-md-6 col-lg-4">
        <select class="form-control" id="employment_status" name="employment_status" onchange="filter_options()">
          <option value="">Employment Status</option>
          <option value="1" selected>Current</option>
          <option value="2">Ex-Employee</option>
        </select>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <div class="table-responsive">
          <table id="staff_table" class="table " style="width: 100%">
            <thead>
              <tr class="info">
                <th>#</th>
                <th>Employee No</th>
                <th>Staff</th>
                <th>Department</th>
                <th>Position</th>
                <th>DOB</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Employment Status</th>
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
    var dataTable = $('#staff_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_staffs") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";
          var employment_status = $('#employment_status').val();

          data._token = token;
          data.employment_status = employment_status;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'staff_no'
        },
        {
          data: 'staff_name'
        },
        {
          data: 'department_name'
        },
        {
          data: 'role_name'
        },
        {
          data: 'dob'
        },
        {
          data: 'staff_mobile'
        },
        {
          data: 'staff_email'
        },
        {
          data: 'employment_status'
        },
        {
          data: 'action',
          orderable: false,
          searchable: false
        }
      ]
    });

    function filter_options() {
      dataTable.draw();
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
  </script>
@endsection
