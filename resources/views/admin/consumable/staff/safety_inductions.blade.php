@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Safety Inductions")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Safety Inductions</h4>
      <div>
        <a href="{{ url("admin/safety_inductions_download_excel?staff_id=") }}" id="excel_download" class="btn btn-white"><i
            class="fa fa-download"></i> Download</a>
      </div>
    </div>

    <div class="d-flex justify-content-center justify-content-lg-end mb-3">
      <div class="col-xs-10 col-md-6 col-lg-4">
        <select class="form-select selectbox_staff" id="staff_id" name="staff_id" onchange="filter_options()">
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
              <table id="inductions_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Staff</th>
                    <th>Client</th>
                    <th>Inducted Site</th>
                    <th>Name of Induction</th>
                    <th>Type of Induction</th>
                    <th>Induction Date</th>
                    <th>Expiry Date</th>
                    <th>Payment Status</th>
                    <th>Evidence of Induction</th>
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
    var dataTable = $('#inductions_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_safety_inductions") }}",
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
          data: 'customer_name'
        },
        {
          data: 'sinduction_site'
        },
        {
          data: 'sinduction_name'
        },
        {
          data: 'type_name'
        },
        {
          data: 'induction_date'
        },
        {
          data: 'expiry_date'
        },
        {
          data: 'pay_status'
        },
        {
          data: 'evidence_copy'
        }
      ]
    });

    function filter_options() {
      var staff_id = $('#staff_id').val();

      var excel_url = window.location.origin + '/admin/safety_inductions_download_excel?staff_id=' + staff_id;

      $("#excel_download").attr("href", excel_url);

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

    $('.selectbox_staff').select2({
      theme: "bootstrap",
      placeholder: "Staff"
    });
  </script>
@endsection
