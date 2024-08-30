@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Cleaning Log")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Add Cleaning Log</h4>
      <div>
        <a href="{{ url("admin/cleaning_logs/" . Request()->segment(3)) }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="cleaning_log_form" action="{{ url("admin/add_cleaning_log/" . Request()->segment(3)) }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Date</label>
                <input type="text" class="form-control" name="cleaning_log_date" id="cleaning_log_date"
                  value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                @if ($errors->has("cleaning_log_date"))
                  <small style="color: red">{{ $errors->first("cleaning_log_date") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Driver</label>
                <input type="text" class="form-control" name="cleaning_log_driver"
                  value="{{ old("cleaning_log_driver") }}" placeholder="Enter Driver" autocomplete="off">
                @if ($errors->has("cleaning_log_driver"))
                  <small style="color: red">{{ $errors->first("cleaning_log_driver") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Type</label>
                <input type="text" class="form-control" name="cleaning_log_type" value="{{ old("cleaning_log_type") }}"
                  placeholder="Enter Type" autocomplete="off">
                @if ($errors->has("cleaning_log_type"))
                  <small style="color: red">{{ $errors->first("cleaning_log_type") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Location</label>
                <input type="text" class="form-control" name="cleaning_log_location"
                  value="{{ old("cleaning_log_location") }}" placeholder="Enter Location" autocomplete="off">
                @if ($errors->has("cleaning_log_location"))
                  <small style="color: red">{{ $errors->first("cleaning_log_location") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Service Provider</label>
                <input type="text" class="form-control" name="cleaning_log_provider"
                  value="{{ old("cleaning_log_provider") }}" placeholder="Enter Service Provider" autocomplete="off">
                @if ($errors->has("cleaning_log_provider"))
                  <small style="color: red">{{ $errors->first("cleaning_log_provider") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Cost</label>
                <input type="text" class="form-control" name="cleaning_log_cost"
                  value="{{ old("cleaning_log_cost") }}" placeholder="Enter Cost" autocomplete="off">
                @if ($errors->has("cleaning_log_cost"))
                  <small style="color: red">{{ $errors->first("cleaning_log_cost") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="cleaning_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old("cleaning_log_notes") }}</textarea>
                @if ($errors->has("cleaning_log_notes"))
                  <small style="color: red">{{ $errors->first("cleaning_log_notes") }}</small>
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
      $('#cleaning_log_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
