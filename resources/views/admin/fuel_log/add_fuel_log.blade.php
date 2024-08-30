@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Fuel Log")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Vehicles</h4>
      <div>
        <a href="{{ url("admin/fuel_logs/" . Request()->segment(3)) }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="fuel_log_form" action="{{ url("admin/add_fuel_log/" . Request()->segment(3)) }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Date</label>
                <input type="text" class="form-control" name="fuel_log_date" id="fuel_log_date"
                  value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                @if ($errors->has("fuel_log_date"))
                  <small style="color: red">{{ $errors->first("fuel_log_date") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Driver</label>
                <input type="text" class="form-control" name="fuel_log_driver" value="{{ old("fuel_log_driver") }}"
                  placeholder="Enter Driver" autocomplete="off">
                @if ($errors->has("fuel_log_driver"))
                  <small style="color: red">{{ $errors->first("fuel_log_driver") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Odometer Reading</label>
                <input type="text" class="form-control" name="fuel_log_odometer" value="{{ old("fuel_log_odometer") }}"
                  placeholder="Enter Odometer Reading" autocomplete="off">
                @if ($errors->has("fuel_log_odometer"))
                  <small style="color: red">{{ $errors->first("fuel_log_odometer") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Fuel Added (L)</label>
                <input type="text" class="form-control" name="fuel_log_fadded" value="{{ old("fuel_log_fadded") }}"
                  placeholder="Enter Fuel Added (L)" autocomplete="off">
                @if ($errors->has("fuel_log_fadded"))
                  <small style="color: red">{{ $errors->first("fuel_log_fadded") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Cost</label>
                <input type="text" class="form-control" name="fuel_log_cost" value="{{ old("fuel_log_cost") }}"
                  placeholder="Enter Cost" autocomplete="off">
                @if ($errors->has("fuel_log_cost"))
                  <small style="color: red">{{ $errors->first("fuel_log_cost") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="fuel_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old("fuel_log_notes") }}</textarea>
                @if ($errors->has("fuel_log_notes"))
                  <small style="color: red">{{ $errors->first("fuel_log_notes") }}</small>
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
      $('#fuel_log_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
