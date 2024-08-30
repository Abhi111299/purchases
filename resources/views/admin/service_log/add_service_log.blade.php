@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Service Log")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Vehicles: Add Service log</h4>
      <div>
        <a href="{{ url("admin/service_logs/" . Request()->segment(3)) }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="service_log_form" action="{{ url("admin/add_service_log/" . Request()->segment(3)) }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Date</label>
                <input type="text" class="form-control" name="service_log_date" id="service_log_date"
                  value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                @if ($errors->has("service_log_date"))
                  <small style="color: red">{{ $errors->first("service_log_date") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Requested By</label>
                <select name="service_log_requested" id="service_log_requested" class="form-control selectbox">
                  <option value="">Select</option>
                  @foreach ($staffs as $staff)
                    <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname . " " . $staff->staff_lname }}
                    </option>
                  @endforeach
                </select>
                @if ($errors->has("service_log_requested"))
                  <small style="color: red">{{ $errors->first("service_log_requested") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Odometer Reading</label>
                <input type="text" class="form-control" name="service_log_odometer"
                  value="{{ old("service_log_odometer") }}" placeholder="Enter Odometer Reading" autocomplete="off">
                @if ($errors->has("service_log_odometer"))
                  <small style="color: red">{{ $errors->first("service_log_odometer") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Next Service Odometer</label>
                <input type="text" class="form-control" name="service_log_nodometer"
                  value="{{ old("service_log_nodometer") }}" placeholder="Enter Next Service Odometer" autocomplete="off">
                @if ($errors->has("service_log_nodometer"))
                  <small style="color: red">{{ $errors->first("service_log_nodometer") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Service Provider</label>
                <input type="text" class="form-control" name="service_log_provider"
                  value="{{ old("service_log_provider") }}" placeholder="Enter Service Provider" autocomplete="off">
                @if ($errors->has("service_log_provider"))
                  <small style="color: red">{{ $errors->first("service_log_provider") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Cost</label>
                <input type="text" class="form-control" name="service_log_cost" value="{{ old("service_log_cost") }}"
                  placeholder="Enter Cost" autocomplete="off">
                @if ($errors->has("service_log_cost"))
                  <small style="color: red">{{ $errors->first("service_log_cost") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="service_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old("service_log_notes") }}</textarea>
                @if ($errors->has("service_log_notes"))
                  <small style="color: red">{{ $errors->first("service_log_notes") }}</small>
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
      $('#service_log_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
