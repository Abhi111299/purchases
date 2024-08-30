@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Insurance")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Add Insurance</h4>
      <div>
        <a href="{{ url("admin/insurances/" . Request()->segment(3)) }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="insurance_form" action="{{ url("admin/add_insurance/" . Request()->segment(3)) }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Policy Number</label>
                <input type="text" class="form-control" name="insurance_policy_no"
                  value="{{ old("insurance_policy_no") }}" placeholder="Enter Policy Number" autocomplete="off">
                @if ($errors->has("insurance_policy_no"))
                  <small style="color: red">{{ $errors->first("insurance_policy_no") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Expiry Date</label>
                <input type="text" class="form-control" name="insurance_expiry" id="insurance_expiry"
                  value="{{ old("insurance_expiry") }}" placeholder="Select Date" autocomplete="off">
                @if ($errors->has("insurance_expiry"))
                  <small style="color: red">{{ $errors->first("insurance_expiry") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Provider</label>
                <input type="text" class="form-control" name="insurance_provider"
                  value="{{ old("insurance_provider") }}" placeholder="Enter Provider" autocomplete="off">
                @if ($errors->has("insurance_provider"))
                  <small style="color: red">{{ $errors->first("insurance_provider") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Coverage</label>
                <select class="form-control selectbox" name="insurance_coverage">
                  <option value="">Select</option>
                  <option value="1">Liability</option>
                  <option value="2">Comprehensive</option>
                  <option value="3">Collision</option>
                  <option value="4">Third Part</option>
                </select>
                <div id="insurance_coverage_error"></div>
                @if ($errors->has("insurance_coverage"))
                  <small style="color: red">{{ $errors->first("insurance_coverage") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="insurance_notes" placeholder="Enter Notes" autocomplete="off">{{ old("insurance_notes") }}</textarea>
                @if ($errors->has("insurance_notes"))
                  <small style="color: red">{{ $errors->first("insurance_notes") }}</small>
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
  </section>
@endsection
@section("custom_script")
  <script>
    $(function() {
      $('#insurance_expiry').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
