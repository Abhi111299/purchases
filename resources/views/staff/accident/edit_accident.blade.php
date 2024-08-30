@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Edit Accident')
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
                    <div class="btn-group" id="buttonlist">Edit Accident</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('staff/accidents/'.$accident->accident_vehicle) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <form id="accident_form" action="{{ url('staff/edit_accident/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $accident->accident_vehicle }}">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="accident_date" id="accident_date" value="{{ date('d-m-Y',strtotime($accident->accident_date)) }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('accident_date'))
                              <small style="color: red">{{ $errors->first('accident_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                           <label>Time</label>
                           <input type="text" class="form-control" name="accident_time" id="accident_time" value="{{ date('h:i A',strtotime($accident->accident_time)) }}" placeholder="Select Time" autocomplete="off">
                           @if($errors->has('accident_time'))
                           <small style="color: red">{{ $errors->first('accident_time') }}</small>
                           @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Driver</label>
                              <input type="text" class="form-control" name="accident_driver" value="{{ $accident->accident_driver }}" placeholder="Enter Driver" autocomplete="off">
                              @if($errors->has('accident_driver'))
                              <small style="color: red">{{ $errors->first('accident_driver') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Location</label>
                              <input type="text" class="form-control" name="accident_location" value="{{ $accident->accident_location }}" placeholder="Enter Location" autocomplete="off">
                              @if($errors->has('accident_location'))
                              <small style="color: red">{{ $errors->first('accident_location') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Involved Parties</label>
                              <input type="text" class="form-control" name="accident_parties" value="{{ $accident->accident_parties }}" placeholder="Enter Involved Parties" autocomplete="off">
                              @if($errors->has('accident_parties'))
                              <small style="color: red">{{ $errors->first('accident_parties') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Description of Accident</label>
                              <textarea class="form-control" name="accident_desc" placeholder="Enter Description of Accident" autocomplete="off">{{ $accident->accident_desc }}</textarea>
                              @if($errors->has('accident_desc'))
                              <small style="color: red">{{ $errors->first('accident_desc') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Damage Details</label>
                              <textarea class="form-control" name="accident_damage" placeholder="Enter Damage Details" autocomplete="off">{{ $accident->accident_damage }}</textarea>
                              @if($errors->has('accident_damage'))
                              <small style="color: red">{{ $errors->first('accident_damage') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" name="accident_notes" placeholder="Enter Notes" autocomplete="off">{{ $accident->accident_notes }}</textarea>
                              @if($errors->has('accident_notes'))
                              <small style="color: red">{{ $errors->first('accident_notes') }}</small>
                              @endif
                           </div>
                        </div>
                        @php $files = json_decode($accident->accident_photographs,true); @endphp
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Photographs
                                 @if(!empty($accident->accident_photographs))
                                 @foreach($files as $file)
                                 <div>
                                    <a href="{{ asset(config('constants.admin_path').'uploads/vehicle/'.$file) }}" target="_blank">Click Here</a> to View Document {{ $loop->iteration }}
                                 </div>
                                 @endforeach
                                 @endif
                              </label>
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