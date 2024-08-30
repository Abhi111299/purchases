@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Edit Timesheet')
@section('contents')
<section class="content-header">
    <div class="header-title">
       <h1>Timesheets</h1>
    </div>
 </section>
 <section class="content">
    <div class="row">
       <div class="col-sm-12">
          <div class="panel panel-bd">
             <div class="panel-heading">
                <div class="btn-group" id="buttonlist">Edit Timesheet</div>
             </div>
             <div class="panel-body">
                <form id="timesheet_form" action="{{ url('staff/edit_timesheet/'.Request()->segment(3)) }}" method="post">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="timesheet_date" id="timesheet_date" value="{{ date('d-m-Y',strtotime($timesheet->timesheet_date)) }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('timesheet_date'))
                              <small style="color: red">{{ $errors->first('timesheet_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Status</label>
                              <select class="form-control selectbox" id="timesheet_wtype" name="timesheet_wtype">
                                 <option value="">Select</option>
                                 <option value="1" {{ $timesheet->timesheet_wtype == 1 ? 'selected':'' }}>Work</option>
                                 <option value="2" {{ $timesheet->timesheet_wtype == 2 ? 'selected':'' }}>Sick Leave</option>
                                 <option value="3" {{ $timesheet->timesheet_wtype == 3 ? 'selected':'' }}>Annual Leave</option>
                                 <option value="4" {{ $timesheet->timesheet_wtype == 4 ? 'selected':'' }}>Training</option>
                                 <option value="5" {{ $timesheet->timesheet_wtype == 5 ? 'selected':'' }}>Travelling</option>
                                 <option value="6" {{ $timesheet->timesheet_wtype == 6 ? 'selected':'' }}>Others</option>
                              </select>
                              @if($errors->has('timesheet_wtype'))
                              <small style="color: red">{{ $errors->first('timesheet_wtype') }}</small>
                              @endif
                              <span id="timesheet_wtype_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Start Time</label>
                              <input type="text" class="form-control" name="timesheet_start" id="timesheet_start" @if(!empty($timesheet->timesheet_start)) value="{{ date('h:i A',strtotime($timesheet->timesheet_start)) }}" @endif placeholder="Select Start Time" autocomplete="off">
                              @if($errors->has('timesheet_start'))
                              <small style="color: red">{{ $errors->first('timesheet_start') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Finish Time</label>
                              <input type="text" class="form-control" name="timesheet_end" id="timesheet_end" @if(!empty($timesheet->timesheet_end)) value="{{ date('h:i A',strtotime($timesheet->timesheet_end)) }}" @endif placeholder="Select Finish Time" autocomplete="off">
                              @if($errors->has('timesheet_end'))
                              <small style="color: red">{{ $errors->first('timesheet_end') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Client</label>
                              <select class="form-control selectbox" id="timesheet_client" name="timesheet_client">
                                 <option value="">Select</option>
                                 @foreach($customers as $customer)
                                 <option value="{{ $customer->customer_id }}" {{ $timesheet->timesheet_client == $customer->customer_id ? 'selected':'' }}>{{ $customer->customer_name }}</option>
                                 @endforeach
                              </select>
                              @if($errors->has('timesheet_client'))
                              <small style="color: red">{{ $errors->first('timesheet_client') }}</small>
                              @endif
                              <span id="timesheet_client_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Location</label>
                              <select class="form-control selectbox" id="timesheet_location" name="timesheet_location">
                                 <option value="">Select</option>
                                 @foreach($locations as $location)
                                 <option value="{{ $location->location_id }}" {{ $timesheet->timesheet_location == $location->location_id ? 'selected':'' }}>{{ $location->location_name }}</option>
                                 @endforeach
                              </select>
                              @if($errors->has('timesheet_location'))
                              <small style="color: red">{{ $errors->first('timesheet_location') }}</small>
                              @endif
                              <span id="timesheet_location_error"></span>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Description</label>
                              <textarea class="form-control" id="timesheet_desc" name="timesheet_desc" placeholder="Enter Description" autocomplete="off">{{ $timesheet->timesheet_desc }}</textarea>
                              @if($errors->has('timesheet_desc'))
                              <small style="color: red">{{ $errors->first('timesheet_desc') }}</small>
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