@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Certificates")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Certificates</h4>
      <div>
        <a href="{{ url("admin/certificates_download_excel?staff_id=") }}" id="excel_download" class="btn btn-white"><i
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
    <div class="card panel-bd">
      <div class="card-body">
        <div class="table-responsive">
          <table id="certificate_table" class="table " style="width: 100%">
            <thead>
              <tr class="info">
                <th>#</th>
                <th>Staff</th>
                <th>Certification Body</th>
                <th>Certification Held</th>
                <th>Level of Qualification</th>
                <th>Certification Date</th>
                <th>Expiry Date</th>
                <th>Payment Status</th>
                <th>Certificate Copy</th>
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
    var dataTable = $('#certificate_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_certificates") }}",
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
          data: 'squalification_cbody'
        },
        {
          data: 'squalification_held'
        },
        {
          data: 'squalification_level'
        },
        {
          data: 'certificate_date'
        },
        {
          data: 'expiry_date'
        },
        {
          data: 'pay_status'
        },
        {
          data: 'certificate_copy'
        }
      ]
    });

    function filter_options() {
      var staff_id = $('#staff_id').val();

      var excel_url = window.location.origin + '/admin/certificates_download_excel?staff_id=' + staff_id;

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
