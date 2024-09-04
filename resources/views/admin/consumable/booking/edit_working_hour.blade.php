@csrf
<input type="hidden" name="wh_id" value="{{ $working_hour->wh_id }}">
<div class="modal-body">
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Date</label>
        <input type="text" class="form-control wh_date" name="wh_date" id="wh_date"
          value="{{ date("d-m-Y", strtotime($working_hour->wh_date)) }}" placeholder="Enter Date" autocomplete="off">
        @if ($errors->has("wh_date"))
          <small style="color: red">{{ $errors->first("wh_date") }}</small>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Technician</label>
        <select class="form-control selectbox" name="wh_technician" style="width: 100%">
          <option value="">Select</option>
          @foreach ($all_staffs as $all_staff)
            <option value="{{ $all_staff->staff_id }}"
              {{ $working_hour->wh_technician == $all_staff->staff_id ? "selected" : "" }}>
              {{ $all_staff->staff_fname . " " . $all_staff->staff_lname }}</option>
          @endforeach
        </select>
        @if ($errors->has("wh_technician"))
          <small style="color: red">{{ $errors->first("wh_technician") }}</small>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Left Base</label>
        <input type="text" class="form-control wh_left_base" name="wh_left_base" id="wh_left_base"
          value="{{ date("h:i A", strtotime($working_hour->wh_left_base)) }}" placeholder="Select Left Base"
          autocomplete="off">
        @if ($errors->has("wh_left_base"))
          <small style="color: red">{{ $errors->first("wh_left_base") }}</small>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Return Base</label>
        <input type="text" class="form-control wh_return_base" name="wh_return_base" id="wh_return_base"
          value="{{ date("h:i A", strtotime($working_hour->wh_return_base)) }}" placeholder="Select Return Base"
          autocomplete="off">
        @if ($errors->has("wh_return_base"))
          <small style="color: red">{{ $errors->first("wh_return_base") }}</small>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Start Time</label>
        <input type="text" class="form-control wh_start_time" name="wh_start_time" id="wh_start_time"
          value="{{ date("h:i A", strtotime($working_hour->wh_start_time)) }}" placeholder="Select Start Time"
          autocomplete="off">
        @if ($errors->has("wh_start_time"))
          <small style="color: red">{{ $errors->first("wh_start_time") }}</small>
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="form-label">Finish Time</label>
        <input type="text" class="form-control wh_finish_time" name="wh_finish_time" id="wh_finish_time"
          value="{{ date("h:i A", strtotime($working_hour->wh_finish_time)) }}" placeholder="Select Finish Time"
          autocomplete="off">
        @if ($errors->has("wh_finish_time"))
          <small style="color: red">{{ $errors->first("wh_finish_time") }}</small>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <button type="submit" name="submit" class="btn btn-add" value="submit">Save</button>
</div>
<script>
  $('.selectbox').select2({
    theme: "bootstrap",
    placeholder: "Select"
  });

  $('.wh_date').datetimepicker({
    format: 'DD-MM-YYYY'
  });

  $('.wh_left_base').datetimepicker({
    format: 'hh:mm A'
  });

  $('.wh_return_base').datetimepicker({
    format: 'hh:mm A'
  });

  $('.wh_start_time').datetimepicker({
    format: 'hh:mm A'
  });

  $('.wh_finish_time').datetimepicker({
    format: 'hh:mm A'
  });
</script>
