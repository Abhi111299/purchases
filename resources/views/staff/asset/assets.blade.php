@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Assets")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Assets</h4>
    </div>
  </section>
  <section class="content">
    <div class="d-flex justify-content-center justify-content-lg-end">
      <div class="col-xs-10">
        <div class="row justify-content-end row-cols-1 row-cols-md-3">
          <div class="col mb-3">
            <div class="form-groupd">
              <select class="form-control selectbox_filter" name="condition" id="condition" onchange="filter_options()">
                <option value="">Condition</option>
                <option value="1">Inservice</option>
                <option value="2">Out of service</option>
                <option value="3">Maintenance</option>
                <option value="4">Calibration out</option>
                <option value="5">Repair</option>
                <option value="6">Send for repair</option>
              </select>
            </div>
          </div>
          <div class="col mb-3">
            <div class="form-group">
              <select class="form-control selectbox_filter" name="location" id="location" onchange="filter_options()">
                <option value="">Location</option>
                @foreach ($locations as $location)
                  <option value="{{ $location->location_id }}">{{ $location->location_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col mb-3">
            <div class="form-group">
              <select class="form-control selectbox_filter" name="calibration" id="calibration"
                onchange="filter_options()">
                <option value="">Calibration Required</option>
                <option value="1">Yes</option>
                <option value="2">No</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card panel-bd">
      <div class="card-body">

        <div class="table-responsive">
          <table id="asset_table" class="table " style="width: 100%">
            <thead>
              <tr class="info">
                <th>#</th>
                <th>Image</th>
                <th>Asset</th>
                <th>Method</th>
                <th>Location</th>
                <th>Department</th>
                <th>Condition</th>
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
    var dataTable = $('#asset_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 20,
      'ajax': {
        type: 'POST',
        url: "{{ url("staff/get_assets") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";
          var condition = $('#condition').val();
          var location = $('#location').val();
          var calibration = $('#calibration').val();

          data._token = token;
          data.condition = condition;
          data.location = location;
          data.calibration = calibration;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'asset_image'
        },
        {
          data: 'asset_name'
        },
        {
          data: 'activity_name'
        },
        {
          data: 'location_name'
        },
        {
          data: 'department_name'
        },
        {
          data: 'condition'
        },
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
          text: 'You want to delete!',
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
