@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Add Trip Log')
@section('contents')
<section class="content-header">
    <div class="header-title">
       <h1>Vehicles</h1>
    </div>
 </section>
 <section class="content">
    <div class="row">
       <div class="col-sm-12">
          <div class="panel panel-bd">
             <div class="panel-heading">
               <div class="row">
                 <div class="col-md-6">
                    <div class="btn-group" id="buttonlist">Add Trip Log</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('staff/trip_logs/'.Request()->segment(3)) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <form id="trip_log_form" action="{{ url('staff/add_trip_log/'.Request()->segment(3)) }}" method="post">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="trip_log_date" id="trip_log_date" value="{{ date('d-m-Y') }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('trip_log_date'))
                              <small style="color: red">{{ $errors->first('trip_log_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                           <label>Driver</label>
                           <input type="text" class="form-control" name="trip_log_driver" value="{{ Auth::guard('staff')->user()->staff_fname.' '.Auth::guard('staff')->user()->staff_lname }}" placeholder="Enter Driver" autocomplete="off">
                           @if($errors->has('trip_log_driver'))
                           <small style="color: red">{{ $errors->first('trip_log_driver') }}</small>
                           @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Start Time</label>
                              <input type="text" class="form-control" name="trip_log_stime" id="trip_log_stime" value="{{ date('h:i A') }}" placeholder="Select Start Time" autocomplete="off">
                              @if($errors->has('trip_log_stime'))
                              <small style="color: red">{{ $errors->first('trip_log_stime') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>End Time</label>
                              <input type="text" class="form-control" name="trip_log_etime" id="trip_log_etime" value="{{ old('trip_log_etime') }}" placeholder="Select End Time" autocomplete="off">
                              @if($errors->has('trip_log_etime'))
                              <small style="color: red">{{ $errors->first('trip_log_etime') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Start Odometer</label>
                              <input type="number" class="form-control" name="trip_log_sodometer" @if(isset($last_trip)) value="{{ $last_trip->trip_log_eodometer }}" @endif placeholder="Enter Start Odometer" autocomplete="off">
                              @if($errors->has('trip_log_sodometer'))
                              <small style="color: red">{{ $errors->first('trip_log_sodometer') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>End Odometer</label>
                              <input type="number" class="form-control" name="trip_log_eodometer" value="{{ old('trip_log_eodometer') }}" placeholder="Enter End Odometer" autocomplete="off">
                              @if($errors->has('trip_log_eodometer'))
                              <small style="color: red">{{ $errors->first('trip_log_eodometer') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Work Details</label>
                              <textarea class="form-control" name="trip_log_details" placeholder="Enter Work Details" autocomplete="off">{{ old('trip_log_details') }}</textarea>
                              @if($errors->has('trip_log_details'))
                              <small style="color: red">{{ $errors->first('trip_log_details') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" name="trip_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old('trip_log_notes') }}</textarea>
                              @if($errors->has('trip_log_notes'))
                              <small style="color: red">{{ $errors->first('trip_log_notes') }}</small>
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
   $('#trip_log_date').datetimepicker({
   format: 'DD-MM-YYYY'
   });

   $('#trip_log_stime').datetimepicker({
   format: 'hh:mm A'
   });

   $('#trip_log_etime').datetimepicker({
   format: 'hh:mm A'
   });
});
</script>
@endsection