@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Repair Log")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Add Repair log</h4>
      <div>
        <a href="{{ url("admin/repair_logs/" . Request()->segment(3)) }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="repair_log_form" action="{{ url("admin/add_repair_log/" . Request()->segment(3)) }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Date</label>
                <input type="text" class="form-control" name="repair_log_date" id="repair_log_date"
                  value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                @if ($errors->has("repair_log_date"))
                  <small style="color: red">{{ $errors->first("repair_log_date") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Odometer Reading</label>
                <input type="text" class="form-control" name="repair_log_odometer"
                  value="{{ old("repair_log_odometer") }}" placeholder="Enter Odometer Reading" autocomplete="off">
                @if ($errors->has("repair_log_odometer"))
                  <small style="color: red">{{ $errors->first("repair_log_odometer") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Repair requested by</label>
                <select name="repair_log_performed" id="repair_log_performed" class="form-control selectbox">
                  <option value="">Select</option>
                  @foreach ($staffs as $staff)
                    <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname . " " . $staff->staff_lname }}
                    </option>
                  @endforeach
                </select>
                @if ($errors->has("repair_log_performed"))
                  <small style="color: red">{{ $errors->first("repair_log_performed") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Parts Replaced</label>
                <input type="text" class="form-control" name="repair_log_replaced"
                  value="{{ old("repair_log_replaced") }}" placeholder="Enter Parts Replaced" autocomplete="off">
                @if ($errors->has("repair_log_replaced"))
                  <small style="color: red">{{ $errors->first("repair_log_replaced") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Labor Cost</label>
                <input type="text" class="form-control" name="repair_log_lcost" value="{{ old("repair_log_lcost") }}"
                  placeholder="Enter Labor Cost" autocomplete="off">
                @if ($errors->has("repair_log_lcost"))
                  <small style="color: red">{{ $errors->first("repair_log_lcost") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Parts Cost</label>
                <input type="text" class="form-control" name="repair_log_pcost" value="{{ old("repair_log_pcost") }}"
                  placeholder="Enter Parts Cost" autocomplete="off">
                @if ($errors->has("repair_log_pcost"))
                  <small style="color: red">{{ $errors->first("repair_log_pcost") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Total Cost</label>
                <input type="text" class="form-control" name="repair_log_cost" value="{{ old("repair_log_cost") }}"
                  placeholder="Enter Total Cost" autocomplete="off">
                @if ($errors->has("repair_log_cost"))
                  <small style="color: red">{{ $errors->first("repair_log_cost") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Service Provider</label>
                <input type="text" class="form-control" name="repair_log_provider"
                  value="{{ old("repair_log_provider") }}" placeholder="Enter Service Provider" autocomplete="off">
                @if ($errors->has("repair_log_provider"))
                  <small style="color: red">{{ $errors->first("repair_log_provider") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="repair_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old("repair_log_notes") }}</textarea>
                @if ($errors->has("repair_log_notes"))
                  <small style="color: red">{{ $errors->first("repair_log_notes") }}</small>
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
      $('#repair_log_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
