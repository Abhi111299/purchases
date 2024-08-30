@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Add Inspection')
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
                    <div class="btn-group" id="buttonlist">Add Inspection</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('staff/inspections/'.Request()->segment(3)) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <form id="inspection_form" action="{{ url('staff/add_inspection/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Date</label>
                              <input type="text" class="form-control" name="inspection_date" id="inspection_date" value="{{ date('d-m-Y') }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('inspection_date'))
                              <small style="color: red">{{ $errors->first('inspection_date') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Odometer Reading</label>
                              <input type="text" class="form-control" name="inspection_odometer" value="{{ old('inspection_odometer') }}" placeholder="Enter Odometer Reading" autocomplete="off">
                              @if($errors->has('inspection_odometer'))
                              <small style="color: red">{{ $errors->first('inspection_odometer') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Inspected By</label>
                              <input type="text" class="form-control" name="inspection_inspected" value="{{ old('inspection_inspected') }}" placeholder="Enter Inspected By" autocomplete="off">
                              @if($errors->has('inspection_inspected'))
                              <small style="color: red">{{ $errors->first('inspection_inspected') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Inspection Frequency</label>
                              <input type="text" class="form-control" name="inspection_frequency" value="{{ old('inspection_frequency') }}" placeholder="Enter Inspection Frequency" autocomplete="off">
                              @if($errors->has('inspection_frequency'))
                              <small style="color: red">{{ $errors->first('inspection_frequency') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Next Inspection</label>
                              <input type="text" class="form-control" name="inspection_ninspection" value="{{ old('inspection_ninspection') }}" placeholder="Enter Next Inspection" autocomplete="off">
                              @if($errors->has('inspection_ninspection'))
                              <small style="color: red">{{ $errors->first('inspection_ninspection') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" name="inspection_notes" placeholder="Enter Notes" autocomplete="off">{{ old('inspection_notes') }}</textarea>
                              @if($errors->has('inspection_notes'))
                              <small style="color: red">{{ $errors->first('inspection_notes') }}</small>
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
   $('#inspection_date').datetimepicker({
   format: 'DD-MM-YYYY'
   });
});
</script>
@endsection