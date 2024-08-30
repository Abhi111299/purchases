@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Add Accident')
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
                    <div class="btn-group" id="buttonlist">Add Accident</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('staff/accidents/'.Request()->segment(3)) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <form id="accident_form" action="{{ url('staff/add_accident/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="accident_date" id="accident_date" value="{{ date('d-m-Y') }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('accident_date'))
                              <small style="color: red">{{ $errors->first('accident_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                           <label>Time</label>
                           <input type="text" class="form-control" name="accident_time" id="accident_time" value="{{ old('accident_time') }}" placeholder="Select Time" autocomplete="off">
                           @if($errors->has('accident_time'))
                           <small style="color: red">{{ $errors->first('accident_time') }}</small>
                           @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Driver</label>
                              <input type="text" class="form-control" name="accident_driver" value="{{ Auth::guard('staff')->user()->staff_fname.' '.Auth::guard('staff')->user()->staff_lname }}" placeholder="Enter Driver" autocomplete="off">
                              @if($errors->has('accident_driver'))
                              <small style="color: red">{{ $errors->first('accident_driver') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Location</label>
                              <input type="text" class="form-control" name="accident_location" value="{{ old('accident_location') }}" placeholder="Enter Location" autocomplete="off">
                              @if($errors->has('accident_location'))
                              <small style="color: red">{{ $errors->first('accident_location') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Involved Parties</label>
                              <input type="text" class="form-control" name="accident_parties" value="{{ old('accident_parties') }}" placeholder="Enter Involved Parties" autocomplete="off">
                              @if($errors->has('accident_parties'))
                              <small style="color: red">{{ $errors->first('accident_parties') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Description of Accident</label>
                              <textarea class="form-control" name="accident_desc" placeholder="Enter Description of Accident" autocomplete="off">{{ old('accident_desc') }}</textarea>
                              @if($errors->has('accident_desc'))
                              <small style="color: red">{{ $errors->first('accident_desc') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Damage Details</label>
                              <textarea class="form-control" name="accident_damage" placeholder="Enter Damage Details" autocomplete="off">{{ old('accident_damage') }}</textarea>
                              @if($errors->has('accident_damage'))
                              <small style="color: red">{{ $errors->first('accident_damage') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" name="accident_notes" placeholder="Enter Notes" autocomplete="off">{{ old('accident_notes') }}</textarea>
                              @if($errors->has('accident_notes'))
                              <small style="color: red">{{ $errors->first('accident_notes') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Photographs</label>
                              <input type="file" class="form-control" name="accident_photographs[]" multiple>
                              @if($errors->has('accident_photographs'))
                              <small style="color: red">{{ $errors->first('accident_photographs') }}</small>
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
   $('#accident_date').datetimepicker({
   format: 'DD-MM-YYYY'
   });

   $('#accident_time').datetimepicker({
   format: 'hh:mm A'
   });
});
</script>
@endsection