@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Trainings")
@section("contents")
  {{-- <section class="content-header">
    <div class="header-title">
      <h1>Trainings</h1>
    </div>
  </section> --}}
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Trainings</h4>
      <div>
        <a href="{{ url("admin/add_training") }}" class="btn btn-white"><i class="fa fa-plus"></i> Add
          Training</a>
      </div>
    </div>

    <div class="card card-body">
      <div class="table-responsive">
        <table id="training_table" class="table" style="width: 100%">
          <thead>
            <tr class="info">
              <th>#</th>
              <th>Training</th>
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
    var dataTable = $('#training_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_trainings") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";

          data._token = token;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'training_name'
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
