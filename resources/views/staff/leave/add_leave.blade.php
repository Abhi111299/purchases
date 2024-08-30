@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Add Leave")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Add Leave</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="leave_form" action="{{ url("staff/add_leave") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Type</label>
                    <select class="form-control selectbox" id="leave_type" name="leave_type">
                      <option value="">Select</option>
                      <option value="1">Sick Leave</option>
                      <option value="2">Annual Leave</option>
                      <option value="3">Parental Leave</option>
                      <option value="4">Long Service Leave</option>
                      <option value="5">Other</option>
                    </select>
                    @if ($errors->has("leave_type"))
                      <small style="color: red">{{ $errors->first("leave_type") }}</small>
                    @endif
                    <span id="leave_type_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Apply Date</label>
                    <input type="text" class="form-control" name="leave_date" value="{{ date("d-m-Y") }}"
                      placeholder="Select Apply Date" autocomplete="off" readonly>
                    @if ($errors->has("leave_date"))
                      <small style="color: red">{{ $errors->first("leave_date") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Leave Start Date</label>
                    <input type="date" class="form-control" name="leave_sdate" id="leave_sdate"
                      value="{{ old("leave_sdate") }}" placeholder="Select Leave Start Date" autocomplete="off">
                    @if ($errors->has("leave_sdate"))
                      <small style="color: red">{{ $errors->first("leave_sdate") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Returning to Work</label>
                    <input type="date" class="form-control" name="leave_wdate" id="leave_wdate"
                      value="{{ old("leave_wdate") }}" placeholder="Select Returning to Work" autocomplete="off">
                    @if ($errors->has("leave_wdate"))
                      <small style="color: red">{{ $errors->first("leave_wdate") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Reason</label>
                    <textarea class="form-control" id="leave_reason" name="leave_reason" placeholder="Enter Reason" autocomplete="off">{{ old("leave_reason") }}</textarea>
                    @if ($errors->has("leave_reason"))
                      <small style="color: red">{{ $errors->first("leave_reason") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Leave Requested to</label>
                    <select class="form-control selectbox" id="leave_request" name="leave_request[]" multiple>
                      <option value="">Select</option>
                      @foreach ($staffs as $staff)
                        <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname . " " . $staff->staff_lname }}
                        </option>
                      @endforeach
                    </select>
                    @if ($errors->has("leave_request"))
                      <small style="color: red">{{ $errors->first("leave_request") }}</small>
                    @endif
                    <span id="leave_request_error"></span>
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
