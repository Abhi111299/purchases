@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Vehicles")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Vehicles</h4>
      <div>
        <a href="{{ url("admin/add_vehicle") }}" class="btn btn-white"><i class="fa fa-plus"></i> Add
          Vehicle</a>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <div class="table-responsive">
              <table id="vehicle_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Manufacturer</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>License Plate No</th>
                    <th>Driver</th>
                    <th>Start Odometer</th>
                    <th>Last Odometer</th>
                    <th>Total Kilometre Driven</th>
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
    var dataTable = $('#vehicle_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 20,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_vehicles") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";

          data._token = token;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'manufacturer_name'
        },
        {
          data: 'model_name'
        },
        {
          data: 'vehicle_year'
        },
        {
          data: 'vehicle_license_no'
        },
        {
          data: 'staff_name'
        },
        {
          data: 'start_odometer'
        },
        {
          data: 'last_odometer'
        },
        {
          data: 'total_km'
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
