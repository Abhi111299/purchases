@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Edit Attendance')
@section('contents')
<section class="content-header">
    <div class="header-title">
       <h1>Attendances</h1>
    </div>
 </section>
 <section class="content">
    <div class="row">
       <div class="col-sm-12">
          <div class="panel panel-bd">
             <div class="panel-heading">
                <div class="btn-group" id="buttonlist">Edit Attendance</div>
             </div>
             <div class="panel-body">
                <form id="attendance_form" action="{{ url('staff/edit_attendance/'.Request()->segment(3)) }}" method="post">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="attendance_date" id="attendance_date" value="{{ date('d-m-Y',strtotime($attendance->attendance_date)) }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('attendance_date'))
                              <small style="color: red">{{ $errors->first('attendance_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Attendance</label>
                              <select class="form-control selectbox" id="attendance_type" name="attendance_type">
                                 <option value="">Select</option>
                                 <option value="1" {{ $attendance->attendance_type == 1 ? 'selected':'' }}>Present</option>
                                 <option value="2" {{ $attendance->attendance_type == 2 ? 'selected':'' }}>Absent</option>
                                 <option value="3" {{ $attendance->attendance_type == 3 ? 'selected':'' }}>Half Day</option>
                              </select>
                              @if($errors->has('attendance_type'))
                              <small style="color: red">{{ $errors->first('attendance_type') }}</small>
                              @endif
                              <span id="attendance_type_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" id="attendance_notes" name="attendance_notes" placeholder="Enter Notes" autocomplete="off">{{ $attendance->attendance_notes }}</textarea>
                              @if($errors->has('attendance_notes'))
                              <small style="color: red">{{ $errors->first('attendance_notes') }}</small>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-success" value="submit">Save</button>
                     </div>
                </form>
             </div>
          </div>
       </div>
    </div>
</section>
@endsection
@section('custom_script')
<script>
$(function() {    
   $('#attendance_date').datetimepicker({
   format: 'DD-MM-YYYY'
   });
});
</script>
@endsection