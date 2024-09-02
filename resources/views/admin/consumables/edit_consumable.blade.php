@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit Consumable")
@section("contents")
<section class="content-header">
    <div class="header-title">
        <h4 class="text-white mb-0">Edit Consumable</h4>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card panel-bd">
                <div class="card-body">
                  <form id="leave_form" action="{{ url('admin/edit_consumable/' . $consumable->id) }}" method="post">
                    @csrf
                    <div class="row">
                      <!-- Supplier and other fields populated with $consumable data -->
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Supplier Name</label>
                          <input type="text" class="form-control" name="supplier_name" value="{{ old('supplier_name', $consumable->supplier_name) }}" placeholder="Enter Supplier Name" autocomplete="off">
                          @if ($errors->has('supplier_name'))
                          <small style="color: red">{{ $errors->first('supplier_name') }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Supplier Address</label>
                          <input type="text" class="form-control" name="supplier_address" value="{{ old("supplier_address", $consumable->supplier_address) }}"
                            placeholder="Enter Supplier Address" autocomplete="off">
                          @if ($errors->has("supplier_address"))
                            <small style="color: red">{{ $errors->first("supplier_address") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Phone Number</label>
                          <input type="number" class="form-control" name="phone" value="{{ old("phone", $consumable->phone) }}"
                            placeholder="Enter Phone Number" autocomplete="off">
                          @if ($errors->has("phone"))
                            <small style="color: red">{{ $errors->first("phone") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Purchase Order Date</label>
                          <input type="text" class="form-control" name="purchase_order_date" value="{{$consumable->purchase_order_date ? $consumable->purchase_order_date : '' }}"
                            placeholder="Select Apply Date" autocomplete="off" readonly>
                          @if ($errors->has("purchase_order_date"))
                            <small style="color: red">{{ $errors->first("purchase_order_date") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Quotation Number </label>
                          <input type="number" class="form-control" name="quotation_number" 
                          value="{{ old('quotation_number', $consumable->quotation_number) }}" 
                          placeholder="Enter Quotation Number" autocomplete="off">

                          @if ($errors->has("quotation_number"))
                          <small style="color: red">{{ $errors->first("quotation_number") }}</small>
                          @endif
                        </div>
                      </div>
                                      
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Email</label>
                          <input type="text" class="form-control" name="email" 
                          value="{{ old('email', $consumable->email) }}" 
                          placeholder="Enter email" autocomplete="off">


                          @if ($errors->has("email"))
                          <small style="color: red">{{ $errors->first("email") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Delivery Date</label>
                          <input type="date" class="form-control" name="delivery_date" id="delivery_date"
                          value="{{ $consumable->delivery_date ? $consumable->delivery_date : '' }}" 
                          placeholder="Select Delivery Date" autocomplete="off">

                          @if ($errors->has("delivery_date"))
                          <small style="color: red">{{ $errors->first("delivery_date") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Delivery Address</label>
                          <textarea class="form-control" id="delivery_address" name="delivery_address" placeholder="Enter Delivery Address" autocomplete="off">
                          {{ $consumable->delivery_address }}
                          </textarea>
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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($consumable->items as $index => $item)
                                  <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                    <select class="form-control item-select" name="supplier[{{ $index }}][item]">
                                      <option value="">Select Item</option>
                                      @foreach($item as $availableItem) 
                                      <option value="">
                                      {{ $availableItem }}
                                      </option>
                                      @endforeach 
                                    </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="supplier[{{ $index }}][description]" value="{{ $item->description }}" placeholder="Item Description"></td>
                                    <td><input type="number" class="form-control quantity" name="supplier[{{ $index }}][quantity]" value="{{ $item->quantity }}" placeholder="Quantity"></td>
                                    <td><input type="number" class="form-control cost" name="supplier[{{ $index }}][cost]" value="{{ $item->cost }}" placeholder="Cost"></td>
                                    <td>
                                    <button type="button" class="btn btn-danger remove-row">
                                    <i class="fa fa-trash"></i>
                                    </button>
                                    <button type="button" id="add_row" class="btn btn-success add-row">
                                    <i class="fa fa-plus"></i>
                                    </button>
                                    </td>
                                  </tr>
                                @endforeach

                                <tr id="subtotal_row">
                      <td></td>
                      <td></td>
                      <td>Subtotal</td>
                      <td></td>
                      <td><input type="number" name="subtotal" value="{{$consumable->subtotal }}"  id="subtotal" class="form-control" name="subtotal" readonly></td>
                      <td></td>
                    </tr>
                    <tr id="shipping_row">
                      <td></td>
                      <td></td>
                      <td>Shipping & Handling</td>
                      <td></td>
                      <td><input type="number" value="{{$consumable->shipping }}" id="shipping" class="form-control" name="shipping" value="0" step="0.01"></td>
                      <td></td>
                    </tr>
                    <tr id="total_without_gst_row">
                      <td></td>
                      <td></td>
                      <td>Total without GST</td>
                      <td></td>
                      <td><input type="number" value="{{$consumable->total_without_gst }}" id="total_without_gst" class="form-control" name="total_without_gst" readonly></td>
                      <td></td>
                    </tr>
                    <tr id="gst_row">
                      <td></td>
                      <td></td>
                      <td>GST (10%)</td>
                      <td></td>
                      <td><input type="number" name="gst" value="{{$consumable->gst }}" id="gst" class="form-control" name="gst" readonly></td>
                      <td></td>
                    </tr>
                    <tr id="total_row">
                      <td></td>
                      <td></td>
                      <td>TOTAL</td>
                      <td></td>
                      <td><input type="number" name="total" value="{{$consumable->total }}" id="total" class="form-control" name="total" readonly></td>
                      <td></td>
                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="reset-button">
                            <button type="submit" name="submit" class="btn btn-primary" value="submit">Update</button>
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
        let options = '<option value="">Select Item</option>';
        $.each(data.suppliers, function(index, supplier) {
          options += `<option value="${supplier.id}">${supplier.supplier_name}</option>`;
        });
        // Update existing and future dropdowns
        $('#supplier_table select').each(function() {
          $(this).html(options);
        });
      },
      error: function(xhr) {
        console.error('Failed to fetch suppliers:', xhr);
      }
    });
  }

  $('#supplier_table').on('click', '.add-row', function() {
    fetchSuppliers();
    $('#supplier_table tbody').find('#subtotal_row').before(`
      <tr>
        <td>${rowIndex + 1}</td>
        <td>
          <select class="form-control item-select" name="supplier[${rowIndex}][item]">
            <option value="">Select Item</option>
            <!-- Add options dynamically or statically -->
          </select>
        </td>
        <td><input type="text" class="form-control" name="supplier[${rowIndex}][description]" placeholder="Item Description"></td>
        <td><input type="number" class="form-control quantity" name="supplier[${rowIndex}][quantity]" placeholder="Quantity"></td>
        <td><input type="number" class="form-control cost" name="supplier[${rowIndex}][cost]" placeholder="Cost"></td>
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
    calculateTotals();
  });

  $(document).on('click', '.remove-row', function() {
    $(this).closest('tr').remove();
    calculateTotals();
  });

  $('#supplier_table').on('input', '.quantity, .cost', function() {
    calculateTotals();
  });

  function calculateTotals() {
    let subtotal = 0;
    $('#supplier_table .quantity').each(function() {
      let quantity = parseFloat($(this).val()) || 0;
      let row = $(this).closest('tr');
      let cost = parseFloat(row.find('.cost').val()) || 0;
      subtotal += quantity * cost;
    });

    let shipping = parseFloat($('#shipping').val()) || 0;
    let totalWithoutGST = subtotal + shipping;
    let gst = totalWithoutGST * 0.10;
    let total = totalWithoutGST + gst;

    $('#subtotal').val(subtotal.toFixed(2));
    $('#total_without_gst').val(totalWithoutGST.toFixed(2));
    $('#gst').val(gst.toFixed(2));
    $('#total').val(total.toFixed(2));
  }
});
  </script>
@endsection
