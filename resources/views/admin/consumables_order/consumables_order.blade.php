@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Consumable  ")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Consumable List  </h4>
      <div>
        <a href="{{ url("admin/add_consumable_order") }}" id="excel_download" class="btn btn-white"><i
            class="fa fa-download"></i> Add Consumable</a>
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
              <table id="consumable_order_table" class="table " style="width: 100%">
                <thead>
                  <tr class="info">
                    <th>#</th>
                    <th>Purchase Order Number</th>
                    <th>Purchase Order Date </th>
                    <th>Delivery Date </th>
                    <th>Quotation Number </th>
                    <th>Total Cost </th>
                    <th>Supplier Name </th>
                    <th>Requested By </th>
                    <th style="white-space:nowrap">File Download</th>
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
    var dataTable = $('#consumable_order_table').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 25,
      'ajax': {
        type: 'POST',
        url: "{{ url("admin/get_consumables_order") }}",
        'data': function(data) {

          var token = "{{ csrf_token() }}";

          data._token = token;
        }
      },
      columns: [{
          data: 'DT_RowIndex'
        },
        {
          data: 'purchase_order_number'
        },
        {
          data: 'purchase_order_date'
        },
        {
          data: 'delivery_date'
        },
        {
          data: 'quotation_number'
        },
        {
          data: 'total'
        },
        {
          data: 'supplier_name'
        },
        {
          data: 'consumable_added_by'
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
