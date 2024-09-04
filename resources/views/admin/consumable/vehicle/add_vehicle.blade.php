@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Vehicle")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Add Vehicle</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">

          <div class="card-body">
            <form id="vehicle_form" action="{{ url("admin/add_vehicle") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Manufacturer</label>
                    <select class="form-control selectbox" name="vehicle_manufacturer" id="vehicle_manufacturer"
                      onchange="select_model()">
                      <option value="">Select</option>
                      @foreach ($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->manufacturer_id }}">{{ $manufacturer->manufacturer_name }}
                        </option>
                      @endforeach
                    </select>
                    <div id="vehicle_manufacturer_error"></div>
                    @if ($errors->has("vehicle_manufacturer"))
                      <small style="color: red">{{ $errors->first("vehicle_manufacturer") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Model</label>
                    <select class="form-control selectbox" name="vehicle_model" id="vehicle_model">
                      <option value="">Select</option>
                    </select>
                    <div id="vehicle_model_error"></div>
                    @if ($errors->has("vehicle_model"))
                      <small style="color: red">{{ $errors->first("vehicle_model") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Year</label>
                    <input type="text" class="form-control" name="vehicle_year" id="vehicle_year"
                      value="{{ old("vehicle_year") }}" placeholder="Select Year" autocomplete="off">
                    @if ($errors->has("vehicle_year"))
                      <small style="color: red">{{ $errors->first("vehicle_year") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">License Plate No</label>
                    <input type="text" class="form-control" name="vehicle_license_no"
                      value="{{ old("vehicle_license_no") }}" placeholder="Enter License Plate No" autocomplete="off">
                    @if ($errors->has("vehicle_license_no"))
                      <small style="color: red">{{ $errors->first("vehicle_license_no") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Vehicle Identification No</label>
                    <input type="text" class="form-control" name="vehicle_no" value="{{ old("vehicle_no") }}"
                      placeholder="Enter Vehicle Identification No" autocomplete="off">
                    @if ($errors->has("vehicle_no"))
                      <small style="color: red">{{ $errors->first("vehicle_no") }}</small>
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
    function select_model() {
      var manufacturer_id = $("#vehicle_manufacturer").val();

      var csrf = "{{ csrf_token() }}";

      $.ajax({
        url: "{{ url("admin/select_model") }}",
        type: "post",
        data: "manufacturer_id=" + manufacturer_id + '&_token=' + csrf,
        success: function(data) {

          $("#vehicle_model").html(data);
        }
      });
    }

    $(function() {
      $('#vehicle_year').datetimepicker({
        format: 'YYYY'
      });
    });
  </script>
@endsection
