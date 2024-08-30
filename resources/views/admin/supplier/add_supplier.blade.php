@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Supplier")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Add Supplier</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="leave_form" action="{{ url("admin/add_supplier") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Item Name</label>
                    <input type="text" class="form-control" name="item_name" value="{{ old("item_name") }}"
                      placeholder="Enter Item Name" autocomplete="off">
                    @if ($errors->has("item_name"))
                      <small style="color: red">{{ $errors->first("item_name") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Request Date</label>
                    <input type="text" class="form-control" name="request_date" value="{{ date("d-m-Y") }}"
                      placeholder="Select Apply Date" autocomplete="off" readonly>
                    @if ($errors->has("request_date"))
                      <small style="color: red">{{ $errors->first("request_date") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Unit</label>
                    <input type="number" class="form-control" name="unit" value="{{ old("unit") }}"
                      placeholder="Enter Unit" autocomplete="off">
                    @if ($errors->has("unit"))
                      <small style="color: red">{{ $errors->first("unit") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" value="{{ old('price') }}"
                    placeholder="Enter price" autocomplete="off" step="0.01" min="0">

                    @if ($errors->has("price"))
                      <small style="color: red">{{ $errors->first("price") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter Reason" autocomplete="off">{{ old("description") }}</textarea>
                    @if ($errors->has("description"))
                      <small style="color: red">{{ $errors->first("description") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Requested to Approval</label>
                    <select class="form-control selectbox" id="request_to_approval" name="request_to_approval[]">
                      <option value="">Select</option>
                      @foreach ($staffs as $staff)
                        <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname . " " . $staff->staff_lname }}
                        </option>
                      @endforeach
                    </select>
                    @if ($errors->has("request_to_approval"))
                      <small style="color: red">{{ $errors->first("request_to_approval") }}</small>
                    @endif
                  </div>
                </div>
              </div>
              <!-- Dynamic Table Section -->
              <div class="form-group">
                <label class="form-label">Supplier Details</label>
                <table class="table table-bordered" id="supplier_table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Supplier</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="text" class="form-control" name="supplier[0][id]" placeholder="ID"></td>
                      <td><select class="form-control" name="supplier[0][supplier]" placeholder="Supplier">
                            <option value="">Select Supplier</option>
                          </select></td>
                      <td><input type="email" class="form-control" name="supplier[0][email]" placeholder="Email"></td>
                      <td><input type="text" class="form-control" name="supplier[0][phone]" placeholder="Phone"></td>
                      <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                    </tr>
                  </tbody>
                </table>
                <button type="button" id="add_row" class="btn btn-success">Add Row</button>
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
      // Add Row
      let rowIndex = 1;

      function fetchSuppliers() {
        $.ajax({
          url: '{{ url("api/get_suppliers") }}', // Replace with your API endpoint
          method: 'GET',
          success: function(data) {
            let options = '<option value="">Select Supplier</option>';
            $.each(data.suppliers, function(index, supplier) {
              options += `<option value="${supplier.id}">${supplier.name}</option>`;
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


      $('#add_row').on('click', function() {
        $('#supplier_table tbody').append(`
          <tr>
            <td><input type="text" class="form-control" name="supplier[${rowIndex}][id]" placeholder="ID"></td>
            <td><select class="form-control" name="supplier[${rowIndex}][supplier]" placeholder="Supplier">
                <option value="">Select Supplier</option>
              </select></td>
            <td><input type="email" class="form-control" name="supplier[${rowIndex}][email]" placeholder="Email"></td>
            <td><input type="text" class="form-control" name="supplier[${rowIndex}][phone]" placeholder="Phone"></td>
            <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
          </tr>
        `);
        rowIndex++;
      });

      // Remove Row
      $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
      });
      $('#leave_sdate').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#leave_wdate').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
