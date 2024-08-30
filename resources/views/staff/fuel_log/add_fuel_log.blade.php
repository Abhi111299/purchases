@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Add Fuel Log')
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
                    <div class="btn-group" id="buttonlist">Add Fuel Log</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('staff/fuel_logs/'.Request()->segment(3)) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <form id="fuel_log_form" action="{{ url('staff/add_fuel_log/'.Request()->segment(3)) }}" method="post">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="fuel_log_date" id="fuel_log_date" value="{{ date('d-m-Y') }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('fuel_log_date'))
                              <small style="color: red">{{ $errors->first('fuel_log_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                           <label>Driver</label>
                           <input type="text" class="form-control" name="fuel_log_driver" value="{{ Auth::guard('staff')->user()->staff_fname.' '.Auth::guard('staff')->user()->staff_lname }}" placeholder="Enter Driver" autocomplete="off">
                           @if($errors->has('fuel_log_driver'))
                           <small style="color: red">{{ $errors->first('fuel_log_driver') }}</small>
                           @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Odometer Reading</label>
                              <input type="text" class="form-control" name="fuel_log_odometer" value="{{ old('fuel_log_odometer') }}" placeholder="Enter Odometer Reading" autocomplete="off">
                              @if($errors->has('fuel_log_odometer'))
                              <small style="color: red">{{ $errors->first('fuel_log_odometer') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Fuel Added (L)</label>
                              <input type="text" class="form-control" name="fuel_log_fadded" value="{{ old('fuel_log_fadded') }}" placeholder="Enter Fuel Added (L)" autocomplete="off">
                              @if($errors->has('fuel_log_fadded'))
                              <small style="color: red">{{ $errors->first('fuel_log_fadded') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Cost</label>
                              <input type="text" class="form-control" name="fuel_log_cost" value="{{ old('fuel_log_cost') }}" placeholder="Enter Cost" autocomplete="off">
                              @if($errors->has('fuel_log_cost'))
                              <small style="color: red">{{ $errors->first('fuel_log_cost') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" name="fuel_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old('fuel_log_notes') }}</textarea>
                              @if($errors->has('fuel_log_notes'))
                              <small style="color: red">{{ $errors->first('fuel_log_notes') }}</small>
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
   $('#fuel_log_date').datetimepicker({
   format: 'DD-MM-YYYY'
   });
});
</script>
@endsection