@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Add Service Log')
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
                    <div class="btn-group" id="buttonlist">Add Service Log</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('staff/service_logs/'.Request()->segment(3)) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <form id="service_log_form" action="{{ url('staff/add_service_log/'.Request()->segment(3)) }}" method="post">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="service_log_date" id="service_log_date" value="{{ date('d-m-Y') }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('service_log_date'))
                              <small style="color: red">{{ $errors->first('service_log_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                           <label>Requested By</label>
                           <select name="service_log_requested" id="service_log_requested" class="form-control selectbox">
                              <option value="">Select</option>
                              @foreach($staffs as $staff)
                              <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname.' '.$staff->staff_lname }}</option>
                              @endforeach
                           </select>
                           @if($errors->has('service_log_requested'))
                           <small style="color: red">{{ $errors->first('service_log_requested') }}</small>
                           @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Odometer Reading</label>
                              <input type="text" class="form-control" name="service_log_odometer" value="{{ old('service_log_odometer') }}" placeholder="Enter Odometer Reading" autocomplete="off">
                              @if($errors->has('service_log_odometer'))
                              <small style="color: red">{{ $errors->first('service_log_odometer') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Next Service Odometer</label>
                              <input type="text" class="form-control" name="service_log_nodometer" value="{{ old('service_log_nodometer') }}" placeholder="Enter Next Service Odometer" autocomplete="off">
                              @if($errors->has('service_log_nodometer'))
                              <small style="color: red">{{ $errors->first('service_log_nodometer') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Service Provider</label>
                              <input type="text" class="form-control" name="service_log_provider" value="{{ old('service_log_provider') }}" placeholder="Enter Service Provider" autocomplete="off">
                              @if($errors->has('service_log_provider'))
                              <small style="color: red">{{ $errors->first('service_log_provider') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Cost</label>
                              <input type="text" class="form-control" name="service_log_cost" value="{{ old('service_log_cost') }}" placeholder="Enter Cost" autocomplete="off">
                              @if($errors->has('service_log_cost'))
                              <small style="color: red">{{ $errors->first('service_log_cost') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" name="service_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old('service_log_notes') }}</textarea>
                              @if($errors->has('service_log_notes'))
                              <small style="color: red">{{ $errors->first('service_log_notes') }}</small>
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
   $('#service_log_date').datetimepicker({
   format: 'DD-MM-YYYY'
   });
});
</script>
@endsection