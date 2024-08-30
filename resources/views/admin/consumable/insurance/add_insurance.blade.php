@extends('admin.layouts.app')
@section('title',config('constants.site_title').' | Add Insurance')
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
                    <div class="btn-group" id="buttonlist">Add Insurance</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('admin/insurances/'.Request()->segment(3)) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <form id="insurance_form" action="{{ url('admin/add_insurance/'.Request()->segment(3)) }}" method="post">
                    @csrf
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Policy Number</label>
                              <input type="text" class="form-control" name="insurance_policy_no" value="{{ old('insurance_policy_no') }}" placeholder="Enter Policy Number" autocomplete="off">
                              @if($errors->has('insurance_policy_no'))
                              <small style="color: red">{{ $errors->first('insurance_policy_no') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Expiry Date</label>
                              <input type="text" class="form-control" name="insurance_expiry" id="insurance_expiry" value="{{ old('insurance_expiry') }}" placeholder="Select Date" autocomplete="off">
                              @if($errors->has('insurance_expiry'))
                              <small style="color: red">{{ $errors->first('insurance_expiry') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Provider</label>
                              <input type="text" class="form-control" name="insurance_provider" value="{{ old('insurance_provider') }}" placeholder="Enter Provider" autocomplete="off">
                              @if($errors->has('insurance_provider'))
                              <small style="color: red">{{ $errors->first('insurance_provider') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Coverage</label>
                              <select class="form-control selectbox" name="insurance_coverage">
                                 <option value="">Select</option>
                                 <option value="1">Liability</option>
                                 <option value="2">Comprehensive</option>
                                 <option value="3">Collision</option>
                                 <option value="4">Third Part</option>
                              </select>
                              <div id="insurance_coverage_error"></div>
                              @if($errors->has('insurance_coverage'))
                              <small style="color: red">{{ $errors->first('insurance_coverage') }}</small>
                              @endif
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label>Notes</label>
                              <textarea class="form-control" name="insurance_notes" placeholder="Enter Notes" autocomplete="off">{{ old('insurance_notes') }}</textarea>
                              @if($errors->has('insurance_notes'))
                              <small style="color: red">{{ $errors->first('insurance_notes') }}</small>
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
   $('#insurance_expiry').datetimepicker({
   format: 'DD-MM-YYYY'
   });
});
</script>
@endsection