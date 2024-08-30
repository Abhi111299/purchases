@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Add Attendance")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Add Attendances</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="attendance_form" action="{{ url("staff/add_attendance") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Date</label>
                    <input type="text" class="form-control" name="attendance_date" id="attendance_date"
                      value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                    @if ($errors->has("attendance_date"))
                      <small style="color: red">{{ $errors->first("attendance_date") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Attendance</label>
                    <select class="form-control selectbox" id="attendance_type" name="attendance_type">
                      <option value="">Select</option>
                      <option value="1">Present</option>
                      <option value="2">Absent</option>
                      <option value="3">Half Day</option>
                    </select>
                    @if ($errors->has("attendance_type"))
                      <small style="color: red">{{ $errors->first("attendance_type") }}</small>
                    @endif
                    <span id="attendance_type_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" id="attendance_notes" name="attendance_notes" placeholder="Enter Notes"
                      autocomplete="off">{{ old("attendance_notes") }}</textarea>
                    @if ($errors->has("attendance_notes"))
                      <small style="color: red">{{ $errors->first("attendance_notes") }}</small>
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
      $('#attendance_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
