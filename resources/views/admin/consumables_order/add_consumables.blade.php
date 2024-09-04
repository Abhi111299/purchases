@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Consumable")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Add Consumable</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="leave_form" action="{{ url("admin/add_consumable_order") }}" method="post">
              @csrf
              <div class="row">
              <div class="col-md-6 mb-3">
  <div class="form-group">
    <label class="form-label">Supplier Name</label>
    <select class="form-control" name="supplier_name" id="supplier_name">
      <option value="">Select Supplier</option>
      <!-- Options will be populated dynamically -->
    </select>
    @if ($errors->has("supplier_id"))
      <small style="color: red">{{ $errors->first("supplier_id") }}</small>
    @endif
  </div>
</div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Supplier Address</label>
                    <input type="text" class="form-control" name="supplier_address" value="{{ old("supplier_address") }}"
                      placeholder="Enter Supplier Address" autocomplete="off">
                    @if ($errors->has("supplier_address"))
                      <small style="color: red">{{ $errors->first("supplier_address") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="number" class="form-control" name="phone" value="{{ old("phone") }}"
                      placeholder="Enter Phone Number" autocomplete="off">
                    @if ($errors->has("phone"))
                      <small style="color: red">{{ $errors->first("phone") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Purchase Order Date</label>
                    <input type="text" class="form-control" name="purchase_order_date" value="{{ date("d-m-Y") }}"
                      placeholder="Select Apply Date" autocomplete="off" readonly>
                    @if ($errors->has("purchase_order_date"))
                      <small style="color: red">{{ $errors->first("purchase_order_date") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Quotation Number </label>
                    <input type="number" class="form-control" name="quotation_number" value="{{ old("quotation_number") }}"
                      placeholder="Enter Quotation Number" autocomplete="off">
                    @if ($errors->has("quotation_number"))
                      <small style="color: red">{{ $errors->first("quotation_number") }}</small>
                    @endif
                  </div>
                </div>
                
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                    placeholder="Enter email" autocomplete="off" step="0.01" min="0">

                    @if ($errors->has("email"))
                      <small style="color: red">{{ $errors->first("email") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Delivery Date</label>
                    <input type="date" class="form-control" name="delivery_date" id="delivery_date"
                      value="{{ old("delivery_date") }}" placeholder="Select Leave Start Date" autocomplete="off">
                    @if ($errors->has("delivery_date"))
                      <small style="color: red">{{ $errors->first("delivery_date") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Delivery Address</label>
                    <textarea class="form-control" id="delivery_address" name="delivery_address" placeholder="Enter Delivery Address" autocomplete="off">{{ old("delivery_address") }}</textarea>
                    @if ($errors->has("delivery_address"))
                      <small style="color: red">{{ $errors->first("delivery_address") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Upload File</label>
                    <input type="file" class="form-control" name="uploaded_file" id="uploaded_file">
                    @if ($errors->has('uploaded_file'))
                      <small style="color: red">{{ $errors->first('uploaded_file') }}</small>
                    @endif
                  </div>
                </div>
              </div>
              <div class="form-group">
                <table class="table table-bordered" id="supplier_table">
                  <thead>
                    <tr>
                      <th>Sno</th>
                      <th>Item</th>
                      <th>Item Description</th>
                      <th>Quantity</th>
                      <th>Cost</th>
                      <th>Total Per Item</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>
                        <select class="form-control item-select consumable_name" name="consumable[0][item]" id="consumable_name">
                          <option value="">Select Item</option>
                          <!-- Add options dynamically or statically -->
                        </select>
                      </td>
                      <td><input type="text" class="form-control" name="consumable[0][description]" placeholder="Item Description"></td>
                      <td><input type="number" class="form-control quantity" name="consumable[0][quantity]" placeholder="Quantity"></td>
                      <td><input type="number" class="form-control cost" name="consumable[0][cost]" placeholder="Cost"></td>
                      <td><input type="number" class="form-control total_per_item" name="consumable[0][total_per_item]" placeholder="Total Per Item" readonly></td>
                      <td>
                        <!-- <button type="button" class="btn btn-danger remove-row">
                          <i class="fa fa-trash"></i>
                        </button> -->
                        <button type="button" id="add_row" class="btn btn-success add-row">
                          <i class="fa fa-plus"></i>
                        </button>
                      </td>
                    </tr>
                    <tr id="subtotal_row">
                      <td></td>
                      <td></td>
                      <td>Subtotal</td>
                      <td></td>
                      <td><input type="number" id="subtotal" class="form-control" name="subtotal" readonly></td>
                      <td></td>
                    </tr>
                    <tr id="shipping_row">
                      <td></td>
                      <td></td>
                      <td>Shipping & Handling</td>
                      <td></td>
                      <td><input type="number" id="shipping" class="form-control" name="shipping" value="0" step="0.01"></td>
                      <td></td>
                    </tr>
                    <tr id="total_without_gst_row">
                      <td></td>
                      <td></td>
                      <td>Total without GST</td>
                      <td></td>
                      <td><input type="number" id="total_without_gst" class="form-control" name="total_without_gst" readonly></td>
                      <td></td>
                    </tr>
                    <tr id="gst_row">
                      <td></td>
                      <td></td>
                      <td>GST (10%)</td>
                      <td></td>
                      <td><input type="number" id="gst" class="form-control" name="gst" readonly></td>
                      <td></td>
                    </tr>
                    <tr id="total_row">
                      <td></td>
                      <td></td>
                      <td>TOTAL</td>
                      <td></td>
                      <td><input type="number" id="total" class="form-control" name="total" readonly></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="reset-button">
                <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section("custom_script")
  <script>
   $(function() {
  let rowIndex = 1;

  fetchSuppliers();

  function fetchSuppliers() {
    $.ajax({
      url: '{{ url("admin/supplier_list") }}', // Replace with your API endpoint
      method: 'GET',
      success: function(data) {
        let options = '<option value="">Select Supplier</option>';
        $.each(data.suppliers, function(index, supplier) {
          options += `<option value="${supplier.id}">${supplier.supplier_name}</option>`;
        });
        // Populate the supplier dropdown
        $('#supplier_name').html(options);
      },
      error: function(xhr) {
        console.error('Failed to fetch suppliers:', xhr);
      }
    });
  }

  fetchConsumables();

  function fetchConsumables() {
    $.ajax({
      url: '{{ url("admin/consumable_list") }}', // Replace with your API endpoint
      method: 'GET',
      success: function(data) {
        let options = '<option value="">Select Item</option>';
        $.each(data.consumable, function(index, consumable) {
          options += `<option value="${consumable.consumable_id}">${consumable.consumable_name}</option>`;
        });
        // Populate the consumable dropdowns
        $('.consumable_name').html(options);
      },
      error: function(xhr) {
        console.error('Failed to fetch consumables:', xhr);
      }
    });
  }

  $('#supplier_table').on('click', '.add-row', function() {
    fetchConsumables();
    $('#supplier_table tbody').find('#subtotal_row').before(`
      <tr>
        <td>${rowIndex + 1}</td>
        <td>
          <select class="form-control item-select consumable_name" name="consumable[${rowIndex}][item]" id="consumable_name">
            <option value="">Select Item</option>
            <!-- Add options dynamically or statically -->
          </select>
        </td>
        <td><input type="text" class="form-control" name="consumable[${rowIndex}][description]" placeholder="Item Description"></td>
        <td><input type="number" class="form-control quantity" name="consumable[${rowIndex}][quantity]" placeholder="Quantity"></td>
        <td><input type="number" class="form-control cost" name="consumable[${rowIndex}][cost]" placeholder="Cost"></td>
        <td><input type="number" class="form-control total_per_item" name="consumable[${rowIndex}][total_per_item]" placeholder="Total Per Item" readonly></td> <!-- New column for Total Per Item -->
        <td>
          <button type="button" class="btn btn-danger remove-row">
            <i class="fa fa-trash"></i>
          </button>
          <button type="button" class="btn btn-success add-row">
            <i class="fa fa-plus"></i>
          </button>
        </td>
      </tr>
    `);
    rowIndex++;
  });

  $(document).on('input', '.quantity, .cost', function() {
    calculateRowTotal($(this).closest('tr'));
    calculateTotals();
  });

  $(document).on('click', '.remove-row', function() {
    $(this).closest('tr').remove();
    calculateTotals();
  });

  function calculateRowTotal(row) {
    const quantity = parseFloat(row.find('.quantity').val()) || 0;
    const cost = parseFloat(row.find('.cost').val()) || 0;
    const totalPerItem = quantity * cost;
    row.find('.total_per_item').val(totalPerItem.toFixed(2));
  }

  function calculateTotals() {
    let subtotal = 0;
    $('#supplier_table tbody tr').each(function() {
      const totalPerItem = parseFloat($(this).find('.total_per_item').val()) || 0;
      subtotal += totalPerItem;
    });

    $('#subtotal').val(subtotal.toFixed(2));
    const shipping = parseFloat($('#shipping').val()) || 0;
    const totalWithoutGst = subtotal + shipping;
    $('#total_without_gst').val(totalWithoutGst.toFixed(2));
    const gst = totalWithoutGst * 0.10; // Assuming GST is 10%
    $('#gst').val(gst.toFixed(2));
    const total = totalWithoutGst + gst;
    $('#total').val(total.toFixed(2));
  }
});

  </script>
@endsection
