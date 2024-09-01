@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Procurement  ")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Supplier List  </h4>
      <div>
        <a href="{{ url("admin/add_supplier") }}" id="excel_download" class="btn btn-white"><i
            class="fa fa-download"></i> Add Supplier</a>
      </div>
    </div>

    <div class="d-flex justify-content-center justify-content-lg-end">
      <div class="col-xs-10">
        <div class="row justify-content-end row-cols-1 row-cols-md-3">
          
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">

            <div class="table-responsive">
              <table id="supplier_record_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Supplier Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Postal Code</th>
                    <th>Phone No.</th>
                    <th style="white-space:nowrap">Action</th>
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
    var dataTable = $('#supplier_record_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_supplier_lists") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";

          data._token = token; console.log(data);
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'supplier_name'
        },
        {
          data: 'email'
        },
        {
          data: 'address'
        },
        {
          data: 'state'
        },
        {
          data: 'county'
        },
        {
          data: 'post_code'
        },
        {
          data: 'phone'
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
