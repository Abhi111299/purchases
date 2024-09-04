@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Inspections")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Vehicles</h4>
      <div>
        <a href="{{ url("admin/add_inspection/" . Request()->segment(3)) }}" class="btn btn-white"><i class="fa fa-plus"></i>
          Add Inspection</a>
        <a href="{{ url("admin/vehicles") }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <ul class="nav nav-tabs">
          @include("admin.vehicle.vehicle_menu")
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab1">
            <div class="card-body">
              <div class="table-responsive">
                <table id="inspection_table" class="table " style="width: 100%">
                  <thead>
                    <tr class="info">
                      <th>#</th>
                      <th>Date</th>
                      <th>Odometer Reading</th>
                      <th>Inspected By</th>
                      <th>Inspection Frequency</th>
                      <th>Next Inspection</th>
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
    </div>
  </section>
@endsection
@section("custom_script")
  <script>
    var dataTable = $('#inspection_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 20,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_inspections") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";
          var vehicle_id = "{{ Request()->segment(3) }}";

          data._token = token;
          data.vehicle_id = vehicle_id;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'inspection_date'
        },
        {
          data: 'inspection_odometer'
        },
        {
          data: 'inspection_inspected'
        },
        {
          data: 'inspection_frequency'
        },
        {
          data: 'inspection_ninspection'
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
