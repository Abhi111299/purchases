@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Add Repair Log')
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
                    <div class="btn-group" id="buttonlist">Add Repair Log</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('staff/repair_logs/'.Request()->segment(3)) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <form id="repair_log_form" action="{{ url('staff/add_repair_log/'.Request()->segment(3)) }}" method="post">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="repair_log_date" id="repair_log_date" value="{{ date('d-m-Y') }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('repair_log_date'))
                              <small style="color: red">{{ $errors->first('repair_log_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                           <label>Odometer Reading</label>
                           <input type="text" class="form-control" name="repair_log_odometer" value="{{ old('repair_log_odometer') }}" placeholder="Enter Odometer Reading" autocomplete="off">
                           @if($errors->has('repair_log_odometer'))
                           <small style="color: red">{{ $errors->first('repair_log_odometer') }}</small>
                           @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Repair requested by</label>
                              <select name="repair_log_performed" id="repair_log_performed" class="form-control selectbox">
                                 <option value="">Select</option>
                                 @foreach($staffs as $staff)
                                 <option value="{{ $staff->staff_id }}">{{ $staff->staff_fname.' '.$staff->staff_lname }}</option>
                                 @endforeach
                              </select>
                              @if($errors->has('repair_log_performed'))
                              <small style="color: red">{{ $errors->first('repair_log_performed') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Parts Replaced</label>
                              <input type="text" class="form-control" name="repair_log_replaced" value="{{ old('repair_log_replaced') }}" placeholder="Enter Parts Replaced" autocomplete="off">
                              @if($errors->has('repair_log_replaced'))
                              <small style="color: red">{{ $errors->first('repair_log_replaced') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Labor Cost</label>
                              <input type="text" class="form-control" name="repair_log_lcost" value="{{ old('repair_log_lcost') }}" placeholder="Enter Labor Cost" autocomplete="off">
                              @if($errors->has('repair_log_lcost'))
                              <small style="color: red">{{ $errors->first('repair_log_lcost') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Parts Cost</label>
                              <input type="text" class="form-control" name="repair_log_pcost" value="{{ old('repair_log_pcost') }}" placeholder="Enter Parts Cost" autocomplete="off">
                              @if($errors->has('repair_log_pcost'))
                              <small style="color: red">{{ $errors->first('repair_log_pcost') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Total Cost</label>
                              <input type="text" class="form-control" name="repair_log_cost" value="{{ old('repair_log_cost') }}" placeholder="Enter Total Cost" autocomplete="off">
                              @if($errors->has('repair_log_cost'))
                              <small style="color: red">{{ $errors->first('repair_log_cost') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Service Provider</label>
                              <input type="text" class="form-control" name="repair_log_provider" value="{{ old('repair_log_provider') }}" placeholder="Enter Service Provider" autocomplete="off">
                              @if($errors->has('repair_log_provider'))
                              <small style="color: red">{{ $errors->first('repair_log_provider') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" name="repair_log_notes" placeholder="Enter Notes" autocomplete="off">{{ old('repair_log_notes') }}</textarea>
                              @if($errors->has('repair_log_notes'))
                              <small style="color: red">{{ $errors->first('repair_log_notes') }}</small>
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
   $('#repair_log_date').datetimepicker({
   format: 'DD-MM-YYYY'
   });
});
</script>
@endsection