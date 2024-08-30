@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Procurement  ")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Supplier List  </h4>
      <div>
        <a href="{{ url("admin/add_supplier") }}" id="excel_download" class="btn btn-white"><i
            class="fa fa-download"></i> Add Purchase Request</a>
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
              <table id="purchase_request_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Request ID</th>
                    <th>Request Date</th>
                    <th>Approver Name</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Status</th>
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
    var dataTable = $('#purchase_request_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_purchase_requests") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";

          data._token = token;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'request_number'
        },
        {
          data: 'request_date'
        },
        {
          data: 'staff_full_name'
        },
        {
          data: 'item_name'
        },
        {
          data: 'item_description'
        },
        {
          data: 'unit'
        },
        {
          data: 'price'
        },
        {
          data: 'status'
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
