@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Job")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Add Jobs</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="booking_form" action="{{ url("admin/add_booking") }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Service</label>
                    <select class="form-control selectbox" name="booking_service">
                      <option value="">Select</option>
                      @foreach ($services as $service)
                        <option value="{{ $service->service_id }}">{{ $service->service_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("booking_service"))
                      <small style="color: red">{{ $errors->first("booking_service") }}</small>
                    @endif
                    <span id="booking_service_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Client</label>
                    <select class="form-control selectbox" id="booking_customer" name="booking_customer"
                      onchange="select_customer()">
                      <option value="">Select</option>
                      @foreach ($customers as $customer)
                        <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("booking_customer"))
                      <small style="color: red">{{ $errors->first("booking_customer") }}</small>
                    @endif
                    <span id="booking_customer_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Start Date</label>
                    <input type="datetime-local" class="form-control" id="dbooking_start" name="booking_start"
                      value="{{ old("booking_start") }}" placeholder="Select Start Date" autocomplete="off">
                    @if ($errors->has("booking_start"))
                      <small style="color: red">{{ $errors->first("booking_start") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">End Date</label>
                    <input type="datetime-local" class="form-control" id="booking_endd" name="booking_end"
                      value="{{ old("booking_end") }}" placeholder="Select End Date" autocomplete="off">
                    @if ($errors->has("booking_end"))
                      <small style="color: red">{{ $errors->first("booking_end") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Activities</label>
                    <select class="form-control selectbox" name="booking_activities[]" multiple>
                      <option value="">Select</option>
                      @foreach ($activities as $activity)
                        <option value="{{ $activity->activity_id }}">{{ $activity->activity_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("booking_activities"))
                      <small style="color: red">{{ $errors->first("booking_activities") }}</small>
                    @endif
                    <span id="booking_activities_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Technicians</label>
                    <select class="form-control selectbox" name="booking_staffs[]" multiple>
                      <option value="">Select</option>
                      @foreach ($staffs as $staff)
                        <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname . " " . $staff->staff_lname }}
                        </option>
                      @endforeach
                    </select>
                    @if ($errors->has("booking_staffs"))
                      <small style="color: red">{{ $errors->first("booking_staffs") }}</small>
                    @endif
                    <span id="booking_staffs_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" id="booking_lname" name="booking_lname"
                      value="{{ old("booking_lname") }}" placeholder="Enter Location" autocomplete="off">
                    @if ($errors->has("booking_lname"))
                      <small style="color: red">{{ $errors->first("booking_lname") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Location Link</label>
                    <input type="text" class="form-control" id="booking_llink" name="booking_llink"
                      value="{{ old("booking_llink") }}" placeholder="Enter Location Link" autocomplete="off">
                    @if ($errors->has("booking_llink"))
                      <small style="color: red">{{ $errors->first("booking_llink") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Order No</label>
                    <input type="text" class="form-control" id="booking_order_no" name="booking_order_no"
                      value="{{ old("booking_order_no") }}" placeholder="Enter Order No" autocomplete="off">
                    @if ($errors->has("booking_order_no"))
                      <small style="color: red">{{ $errors->first("booking_order_no") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Client Request No</label>
                    <input type="text" class="form-control" id="booking_crequest_no" name="booking_crequest_no"
                      value="{{ old("booking_crequest_no") }}" placeholder="Enter Client Request No"
                      autocomplete="off">
                    @if ($errors->has("booking_crequest_no"))
                      <small style="color: red">{{ $errors->first("booking_crequest_no") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Client Job No</label>
                    <input type="text" class="form-control" id="booking_cjob_no" name="booking_cjob_no"
                      value="{{ old("booking_cjob_no") }}" placeholder="Enter Client Job No" autocomplete="off">
                    @if ($errors->has("booking_cjob_no"))
                      <small style="color: red">{{ $errors->first("booking_cjob_no") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">File</label>
                    <input type="file" class="form-control" name="booking_file[]" multiple>
                    @if ($errors->has("booking_file"))
                      <small style="color: red">{{ $errors->first("booking_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Branch Location</label>
                    <select class="form-control selectbox" name="booking_branch">
                      <option value="">Select</option>
                      @foreach ($locations as $location)
                        <option value="{{ $location->location_id }}">{{ $location->location_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("booking_branch"))
                      <small style="color: red">{{ $errors->first("booking_branch") }}</small>
                    @endif
                    <span id="booking_branch_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Instruction</label>
                    <textarea class="form-control" id="booking_instruction" name="booking_instruction" placeholder="Enter Instruction"
                      autocomplete="off">{{ old("booking_instruction") }}</textarea>
                    @if ($errors->has("booking_instruction"))
                      <small style="color: red">{{ $errors->first("booking_instruction") }}</small>
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
    function select_customer() {
      var customer_id = $("#booking_customer").val();

      var csrf = "{{ csrf_token() }}";

      $.ajax({
        url: "{{ url("admin/select_customer") }}",
        type: "post",
        data: "customer_id=" + customer_id + '&_token=' + csrf,
        success: function(data) {

          $("#booking_lname").val(data);
        }
      });
    }

    function select_end_date() {
      var start_date = $("#booking_start").val();

      var csrf = "{{ csrf_token() }}";

      $.ajax({
        url: "{{ url("admin/select_end_date") }}",
        type: "post",
        data: "start_date=" + start_date + '&_token=' + csrf,
        success: function(data) {

          $("#booking_end").val(data);
        }
      });
    }

    $(function() {
      $('#booking_start').datetimepicker({
        format: 'DD-MM-YYYY HH:mm'
      });

      $('#booking_start').on('dp.change', function(e) {
        select_end_date();
      });

      $('#booking_end').datetimepicker({
        format: 'DD-MM-YYYY HH:mm'
      });
    });
  </script>
@endsection
