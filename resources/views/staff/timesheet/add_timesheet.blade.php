@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Add Timesheet")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="mb-0 text-white">Add Timesheet</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="timesheet_form" action="{{ url("staff/add_timesheet") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Date</label>
                    <input type="text" class="form-control" name="timesheet_date" id="timesheet_date"
                      value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                    @if ($errors->has("timesheet_date"))
                      <small style="color: red">{{ $errors->first("timesheet_date") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control selectbox" id="timesheet_wtype" name="timesheet_wtype">
                      <option value="">Select</option>
                      <option value="1">Work</option>
                      <option value="2">Sick Leave</option>
                      <option value="3">Annual Leave</option>
                      <option value="4">Training</option>
                      <option value="5">Travelling</option>
                      <option value="6">Saturday Holiday</option>
                      <option value="7">Sunday Holiday</option>
                      <option value="8">Public Holiday</option>
                      <option value="9">Others</option>
                    </select>
                    @if ($errors->has("timesheet_wtype"))
                      <small style="color: red">{{ $errors->first("timesheet_wtype") }}</small>
                    @endif
                    <span id="timesheet_wtype_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Start Time</label>
                    <input type="time" class="form-control" name="timesheet_start" id="timesheet_start"
                      value="{{ old("timesheet_start") }}" placeholder="Select Start Time" autocomplete="off">
                    @if ($errors->has("timesheet_start"))
                      <small style="color: red">{{ $errors->first("timesheet_start") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Finish Time</label>
                    <input type="time" class="form-control" name="timesheet_end" id="timesheet_end"
                      value="{{ old("timesheet_end") }}" placeholder="Select Finish Time" autocomplete="off">
                    @if ($errors->has("timesheet_end"))
                      <small style="color: red">{{ $errors->first("timesheet_end") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Client</label>
                    <select class="form-control selectbox" id="timesheet_client" name="timesheet_client">
                      <option value="">Select</option>
                      @foreach ($customers as $customer)
                        <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("timesheet_client"))
                      <small style="color: red">{{ $errors->first("timesheet_client") }}</small>
                    @endif
                    <span id="timesheet_client_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Location</label>
                    <select class="form-control selectbox" id="timesheet_location" name="timesheet_location">
                      <option value="">Select</option>
                      @foreach ($locations as $location)
                        <option value="{{ $location->location_id }}">{{ $location->location_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("timesheet_location"))
                      <small style="color: red">{{ $errors->first("timesheet_location") }}</small>
                    @endif
                    <span id="timesheet_location_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" id="timesheet_desc" name="timesheet_desc" placeholder="Enter Description"
                      autocomplete="off">{{ old("timesheet_desc") }}</textarea>
                    @if ($errors->has("timesheet_desc"))
                      <small style="color: red">{{ $errors->first("timesheet_desc") }}</small>
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
      $('#timesheet_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#timesheet_start').datetimepicker({
        format: 'hh:mm A'
      });

      $('#timesheet_end').datetimepicker({
        format: 'hh:mm A'
      });
    });
  </script>
@endsection
