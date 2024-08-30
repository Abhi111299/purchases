@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Accident")
@section("contents")
  <section class="content">
    <div class="d-flex justify-content-between align-items-center pb-4">
      <h4 class="text-white">Add Accident</h4>
      <div>
        <a href="{{ url("admin/accidents/" . Request()->segment(3)) }}" class="btn btn-white">Back</a>
      </div>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="accident_form" action="{{ url("admin/add_accident/" . Request()->segment(3)) }}" method="post"
          enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Date</label>
                <input type="text" class="form-control" name="accident_date" id="accident_date"
                  value="{{ date("d-m-Y") }}" placeholder="Select Date" autocomplete="off">
                @if ($errors->has("accident_date"))
                  <small style="color: red">{{ $errors->first("accident_date") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Time</label>
                <input type="text" class="form-control" name="accident_time" id="accident_time"
                  value="{{ old("accident_time") }}" placeholder="Select Time" autocomplete="off">
                @if ($errors->has("accident_time"))
                  <small style="color: red">{{ $errors->first("accident_time") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Driver</label>
                <input type="text" class="form-control" name="accident_driver" value="{{ old("accident_driver") }}"
                  placeholder="Enter Driver" autocomplete="off">
                @if ($errors->has("accident_driver"))
                  <small style="color: red">{{ $errors->first("accident_driver") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Location</label>
                <input type="text" class="form-control" name="accident_location" value="{{ old("accident_location") }}"
                  placeholder="Enter Location" autocomplete="off">
                @if ($errors->has("accident_location"))
                  <small style="color: red">{{ $errors->first("accident_location") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Involved Parties</label>
                <input type="text" class="form-control" name="accident_parties" value="{{ old("accident_parties") }}"
                  placeholder="Enter Involved Parties" autocomplete="off">
                @if ($errors->has("accident_parties"))
                  <small style="color: red">{{ $errors->first("accident_parties") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Description of Accident</label>
                <textarea class="form-control" name="accident_desc" placeholder="Enter Description of Accident" autocomplete="off">{{ old("accident_desc") }}</textarea>
                @if ($errors->has("accident_desc"))
                  <small style="color: red">{{ $errors->first("accident_desc") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Damage Details</label>
                <textarea class="form-control" name="accident_damage" placeholder="Enter Damage Details" autocomplete="off">{{ old("accident_damage") }}</textarea>
                @if ($errors->has("accident_damage"))
                  <small style="color: red">{{ $errors->first("accident_damage") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="accident_notes" placeholder="Enter Notes" autocomplete="off">{{ old("accident_notes") }}</textarea>
                @if ($errors->has("accident_notes"))
                  <small style="color: red">{{ $errors->first("accident_notes") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Photographs</label>
                <input type="file" class="form-control" name="accident_photographs[]" multiple>
                @if ($errors->has("accident_photographs"))
                  <small style="color: red">{{ $errors->first("accident_photographs") }}</small>
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
      $('#accident_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#accident_time').datetimepicker({
        format: 'hh:mm A'
      });
    });
  </script>
@endsection
