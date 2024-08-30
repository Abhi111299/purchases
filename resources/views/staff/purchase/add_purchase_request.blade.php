@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Add Leave")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Add Purchase Request</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="leave_form" action="{{ url("staff/add_purchase_request") }}" method="post">
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
      $('#leave_sdate').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#leave_wdate').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
