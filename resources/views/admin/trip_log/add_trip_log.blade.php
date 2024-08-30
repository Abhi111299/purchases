@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Trip Log")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Vehicles</h4>
      <div>
        <a href="{{ url("admin/trip_logs/" . Request()->segment(3)) }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="trip_log_form" action="{{ url("admin/add_trip_log/" . Request()->segment(3)) }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Date</label>
                <input type="text" class="form-control" name="trip_log_date" id="trip_log_date"
                  value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                @if ($errors->has("trip_log_date"))
                  <small style="color: red">{{ $errors->first("trip_log_date") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Driver</label>
                <input type="text" class="form-control" name="trip_log_driver" value="{{ old("trip_log_driver") }}"
                  placeholder="Enter Driver" autocomplete="off">
                @if ($errors->has("trip_log_driver"))
                  <small style="color: red">{{ $errors->first("trip_log_driver") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Start Time</label>
                <input type="text" class="form-control" name="trip_log_stime" id="trip_log_stime"
                  value="{{ date("h:i A") }}" placeholder="Select Start Time" autocomplete="off">
                @if ($errors->has("trip_log_stime"))
                  <small style="color: red">{{ $errors->first("trip_log_stime") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">End Time</label>
                <input type="text" class="form-control" name="trip_log_etime" id="trip_log_etime"
                  value="{{ old("trip_log_etime") }}" placeholder="Select End Time" autocomplete="off">
                @if ($errors->has("trip_log_etime"))
                  <small style="color: red">{{ $errors->first("trip_log_etime") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Start Odometer</label>
                <input type="number" class="form-control" name="trip_log_sodometer"
                  @if (isset($last_trip)) value="{{ $last_trip->trip_log_eodometer }}" @endif
                  placeholder="Enter Start Odometer" autocomplete="off">
                @if ($errors->has("trip_log_sodometer"))
                  <small style="color: red">{{ $errors->first("trip_log_sodometer") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">End Odometer</label>
                <input type="number" class="form-control" name="trip_log_eodometer"
                  value="{{ old("trip_log_eodometer") }}" placeholder="Enter End Odometer" autocomplete="off">
                @if ($errors->has("trip_log_eodometer"))
                  <small style="color: red">{{ $errors->first("trip_log_eodometer") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Work Details</label>
                <textarea class="form-control" name="trip_log_details" placeholder="Enter Work Details" autocomplete="off">{{ old("trip_log_details") }}</textarea>
                @if ($errors->has("trip_log_details"))
                  <small style="color: red">{{ $errors->first("trip_log_details") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="trip_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old("trip_log_notes") }}</textarea>
                @if ($errors->has("trip_log_notes"))
                  <small style="color: red">{{ $errors->first("trip_log_notes") }}</small>
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
      $('#trip_log_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#trip_log_stime').datetimepicker({
        format: 'hh:mm A'
      });

      $('#trip_log_etime').datetimepicker({
        format: 'hh:mm A'
      });
    });
  </script>
@endsection
