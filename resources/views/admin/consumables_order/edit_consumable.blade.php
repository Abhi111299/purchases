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
                  <form id="leave_form" action="{{ url('admin/edit_consumable_order/' . $consumable->id) }}" method="post">
                    @csrf
                    <div class="row">
                      <!-- Supplier and other fields populated with $consumable data -->
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Supplier Name</label>
                          <select class="form-control" name="supplier_name" id="supplier_name" onchange="fetchSupplierDetails(this.value)">
      <option value="">Select Supplier</option>
      @foreach($supplier as $availableSupplier)
            <option value="{{ $availableSupplier->id }}" 
                {{ $consumable->supplier_name == $availableSupplier->id ? 'selected' : '' }}>
                {{ $availableSupplier->supplier_name }}
            </option>
        @endforeach
    </select>
                          @if ($errors->has('supplier_name'))
                          <small style="color: red">{{ $errors->first('supplier_name') }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Supplier Address</label>
                          <input type="text" class="form-control" id="address" name="supplier_address" value="{{ old("supplier_address", $consumable->supplier_address) }}"
                            placeholder="Enter Supplier Address" autocomplete="off">
                          @if ($errors->has("supplier_address"))
                            <small style="color: red">{{ $errors->first("supplier_address") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Phone Number</label>
                          <input type="number" id="phone" class="form-control" name="phone" value="{{ old("phone", $consumable->phone) }}"
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
                          <input type="text" id="email" class="form-control" name="email" 
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
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($consumable->items as $index => $item)
                                  <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                    <select class="form-control item-select consumable_name" name="consumable[0][item]" id="consumable_name">
                          <option value="">Select Item</option>
                          @foreach($items as $availableItem)
            <option value="{{ $availableItem->consumable_id }}" 
                {{ $item->item == $availableItem->consumable_id ? 'selected' : '' }}>
                {{ $availableItem->consumable_name }}
            </option>
        @endforeach
                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="consumable[{{ $index }}][description]" value="{{ $item->description }}" placeholder="Item Description"></td>
                                    <td><input type="number" class="form-control quantity" name="consumable[{{ $index }}][quantity]" value="{{ $item->quantity }}" placeholder="Quantity"></td>
                                    <td><input type="number" class="form-control cost" name="consumable[{{ $index }}][cost]" value="{{ $item->cost }}" placeholder="Cost"></td>
                                    <td><input type="number" class="form-control total_per_item" name="consumable[{{ $index }}][total_per_item]" value="{{ $item->total_per_item }}" placeholder="Cost"></td>
                                    
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
  

  function fetchConsumables() {debugger;
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


function fetchSupplierDetails(supplierId) {
        if (supplierId) {
            $.ajax({
                url: '{{ url("admin/supplier_details") }}/' + supplierId,  // Assuming this is your API route to fetch supplier details
                method: 'GET',
                success: function(response) { console.log(response);
                    if (response.success) {
                        $('#address').val(response.supplier.address);
                        $('#phone').val(response.supplier.phone);
                        $('#email').val(response.supplier.email);
                    } else {
                        alert('Supplier details could not be fetched');
                    }
                },
                error: function(xhr) {
                    console.error('Failed to fetch supplier details:', xhr);
                }
            });
        } else {
            // Clear the fields if no supplier is selected
            $('#address').val('');
            $('#phone').val('');
            $('#email').val('');
        }
  }

  </script>
@endsection
