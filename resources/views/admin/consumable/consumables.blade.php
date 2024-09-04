@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Consumables")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Consumables</h4>
      <div>
        <a href="{{ url("admin/add_consumable") }}" class="btn btn-white"><i class="lni lni-plus"></i> Add
          Consumable</a>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          {{-- <div class="panel-heading"> --}}
          {{-- <div class="btn-group" id="buttonexport">
              <a href="javascript:void(0)">
                <h4>Consumables</h4>
              </a>
            </div> --}}
          {{-- </div> --}}
          <div class="card-body">

            <div class="table-responsive">
              <table id="consumable_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Consumable</th>
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
    var dataTable = $('#consumable_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_consumables") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";

          data._token = token;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'consumable_name'
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
