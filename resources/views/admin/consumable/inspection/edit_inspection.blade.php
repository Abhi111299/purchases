@extends('admin.layouts.app')
@section('title',config('constants.site_title').' | Edit Inspection')
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
                    <div class="btn-group" id="buttonlist">Edit Inspection</div>
                 </div>
                 <div class="col-md-6 text-right">
                    <a href="{{ url('admin/inspections/'.$inspection->inspection_vehicle) }}" class="btn btn-sm btn-success">Back</a>
                 </div>
               </div>
             </div>
             <div class="panel-body">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab1" data-toggle="tab">Details</a></li>
                  <li><a href="#tab2" data-toggle="tab">Exterior Inspection</a></li>
                  <li><a href="#tab3" data-toggle="tab">Interior Inspection</a></li>
                  <li><a href="#tab4" data-toggle="tab">Under the Hood</a></li>
                  <li><a href="#tab5" data-toggle="tab">Under the Vehicle</a></li>
                  <li><a href="#tab6" data-toggle="tab">Functional Tests</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade in active" id="tab1">
                     <div class="panel-body">
                        <form id="inspection_form" action="{{ url('admin/edit_inspection/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="vehicle_id" value="{{ $inspection->inspection_vehicle }}">
                            <div class="row">
                               <div class="col-md-6">
                                  <div class="form-group">
                                     <label>Date</label>
                                     <input type="text" class="form-control" name="inspection_date" id="inspection_date" value="{{ date('d-m-Y',strtotime($inspection->inspection_date)) }}" placeholder="Select Date" autocomplete="off">
                                     @if($errors->has('inspection_date'))
                                     <small style="color: red">{{ $errors->first('inspection_date') }}</small>
                                     @endif
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="form-group">
                                     <label>Odometer Reading</label>
                                     <input type="text" class="form-control" name="inspection_odometer" value="{{ $inspection->inspection_odometer }}" placeholder="Enter Odometer Reading" autocomplete="off">
                                     @if($errors->has('inspection_odometer'))
                                     <small style="color: red">{{ $errors->first('inspection_odometer') }}</small>
                                     @endif
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="form-group">
                                     <label>Inspected By</label>
                                     <input type="text" class="form-control" name="inspection_inspected" value="{{ $inspection->inspection_inspected }}" placeholder="Enter Inspected By" autocomplete="off">
                                     @if($errors->has('inspection_inspected'))
                                     <small style="color: red">{{ $errors->first('inspection_inspected') }}</small>
                                     @endif
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="form-group">
                                     <label>Inspection Frequency</label>
                                     <input type="text" class="form-control" name="inspection_frequency" value="{{ $inspection->inspection_frequency }}" placeholder="Enter Inspection Frequency" autocomplete="off">
                                     @if($errors->has('inspection_frequency'))
                                     <small style="color: red">{{ $errors->first('inspection_frequency') }}</small>
                                     @endif
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="form-group">
                                     <label>Next Inspection</label>
                                     <input type="text" class="form-control" name="inspection_ninspection" value="{{ $inspection->inspection_ninspection }}" placeholder="Enter Next Inspection" autocomplete="off">
                                     @if($errors->has('inspection_ninspection'))
                                     <small style="color: red">{{ $errors->first('inspection_ninspection') }}</small>
                                     @endif
                                  </div>
                               </div>
                               <div class="col-md-6">
                                  <div class="form-group">
                                     <label>Notes</label>
                                     <textarea class="form-control" name="inspection_notes" placeholder="Enter Notes" autocomplete="off">{{ $inspection->inspection_notes }}</textarea>
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
                  <div class="tab-pane fade" id="tab2">
                     <div class="panel-body">
                        <form id="exterior_inspection_form" action="{{ url('admin/add_exterior_inspection/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="vehicle_id" value="{{ $inspection->inspection_vehicle }}">
                           <div class="row">
                              <div class="col-md-12">
                                 <h4>Body and Paint</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check for dents, scratches, and rust spots</label>
                                    <select class="form-control selectbox" name="inspection_edents" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_edents == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_edents == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_edents == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_edents'))
                                    <small style="color: red">{{ $errors->first('inspection_edents') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Inspect the condition of the paint. Check for dents, scratches, and rust spots</label>
                                 <select class="form-control selectbox" name="inspection_epaints" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_epaints == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_epaints == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_epaints == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_epaints'))
                                 <small style="color: red">{{ $errors->first('inspection_epaints') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Lights and Indicators</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Test all headlights, tail lights, brake lights, turn signals, and hazard lights</label>
                                    <select class="form-control selectbox" name="inspection_ehead_light" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_ehead_light == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_ehead_light == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_ehead_light == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_ehead_light'))
                                    <small style="color: red">{{ $errors->first('inspection_ehead_light') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Check the condition of the light lenses and replace any damaged ones</label>
                                 <select class="form-control selectbox" name="inspection_elight_lense" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_elight_lense == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_elight_lense == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_elight_lense == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_elight_lense'))
                                 <small style="color: red">{{ $errors->first('inspection_elight_lense') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Tires</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect tire tread depth and look for uneven wear</label>
                                    <select class="form-control selectbox" name="inspection_etire_depth" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_etire_depth == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_etire_depth == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_etire_depth == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_etire_depth'))
                                    <small style="color: red">{{ $errors->first('inspection_etire_depth') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Check tire pressure, including the spare tire</label>
                                 <select class="form-control selectbox" name="inspection_etire_pressure" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_etire_pressure == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_etire_pressure == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_etire_pressure == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_etire_pressure'))
                                 <small style="color: red">{{ $errors->first('inspection_etire_pressure') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Look for any signs of damage or punctures</label>
                                 <select class="form-control selectbox" name="inspection_etire_damage" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_etire_damage == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_etire_damage == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_etire_damage == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_etire_damage'))
                                 <small style="color: red">{{ $errors->first('inspection_etire_damage') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Windshield and Windows</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect for cracks, chips, and scratches</label>
                                    <select class="form-control selectbox" name="inspection_ewindow_crack" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_ewindow_crack == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_ewindow_crack == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_ewindow_crack == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_ewindow_crack'))
                                    <small style="color: red">{{ $errors->first('inspection_ewindow_crack') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Test the operation of power windows</label>
                                 <select class="form-control selectbox" name="inspection_ewindow_power" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_ewindow_power == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_ewindow_power == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_ewindow_power == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_ewindow_power'))
                                 <small style="color: red">{{ $errors->first('inspection_ewindow_power') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Wipers and Washers</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check the condition of wiper blades and replace if worn</label>
                                    <select class="form-control selectbox" name="inspection_ewiper_condition" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_ewiper_condition == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_ewiper_condition == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_ewiper_condition == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_ewiper_condition'))
                                    <small style="color: red">{{ $errors->first('inspection_ewiper_condition') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Ensure the washer fluid reservoir is full and the nozzles are functioning properly</label>
                                 <select class="form-control selectbox" name="inspection_ewiper_fluid" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_ewiper_fluid == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_ewiper_fluid == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_ewiper_fluid == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_ewiper_fluid'))
                                 <small style="color: red">{{ $errors->first('inspection_ewiper_fluid') }}</small>
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
                  <div class="tab-pane fade" id="tab3">
                     <div class="panel-body">
                        <form id="interior_inspection_form" action="{{ url('admin/add_interior_inspection/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="vehicle_id" value="{{ $inspection->inspection_vehicle }}">
                           <div class="row">
                              <div class="col-md-12">
                                 <h4>Seats and Seatbelts</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect for any tears, stains, or signs of wear</label>
                                    <select class="form-control selectbox" name="inspection_iseat_tear" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_iseat_tear == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_iseat_tear == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_iseat_tear == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_iseat_tear'))
                                    <small style="color: red">{{ $errors->first('inspection_iseat_tear') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Test the functionality of all seatbelts and ensure they retract properly</label>
                                 <select class="form-control selectbox" name="inspection_iseat_belts" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_iseat_belts == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_iseat_belts == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_iseat_belts == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_iseat_belts'))
                                 <small style="color: red">{{ $errors->first('inspection_iseat_belts') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Dashboard and Controls</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Ensure all dashboard lights are working when the ignition is on</label>
                                    <select class="form-control selectbox" name="inspection_idashboard_light" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_idashboard_light == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_idashboard_light == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_idashboard_light == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_idashboard_light'))
                                    <small style="color: red">{{ $errors->first('inspection_idashboard_light') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Test all controls (AC, heater, defroster, radio, etc.) for proper operation</label>
                                 <select class="form-control selectbox" name="inspection_idashboard_ac" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_idashboard_ac == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_idashboard_ac == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_idashboard_ac == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_idashboard_ac'))
                                 <small style="color: red">{{ $errors->first('inspection_idashboard_ac') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Mirrors</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check the condition and adjustability of rearview and side mirrors</label>
                                    <select class="form-control selectbox" name="inspection_imirror_condition" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_imirror_condition == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_imirror_condition == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_imirror_condition == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_imirror_condition'))
                                    <small style="color: red">{{ $errors->first('inspection_imirror_condition') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Pedals</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect for wear and ensure they operate smoothly</label>
                                    <select class="form-control selectbox" name="inspection_ipedal_wear" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_ipedal_wear == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_ipedal_wear == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_ipedal_wear == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_ipedal_wear'))
                                    <small style="color: red">{{ $errors->first('inspection_ipedal_wear') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Floor Mats</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Ensure they are properly positioned and not obstructing the pedals</label>
                                    <select class="form-control selectbox" name="inspection_ifloor_position" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_ifloor_position == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_ifloor_position == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_ifloor_position == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_ifloor_position'))
                                    <small style="color: red">{{ $errors->first('inspection_ifloor_position') }}</small>
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
                  <div class="tab-pane fade" id="tab4">
                     <div class="panel-body">
                        <form id="hood_inspection_form" action="{{ url('admin/add_hood_inspection/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="vehicle_id" value="{{ $inspection->inspection_vehicle }}">
                           <div class="row">
                              <div class="col-md-12">
                                 <h4>Engine Oil</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check the oil level and condition using the dipstick</label>
                                    <select class="form-control selectbox" name="inspection_hengine_oil" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_hengine_oil == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_hengine_oil == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_hengine_oil == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_hengine_oil'))
                                    <small style="color: red">{{ $errors->first('inspection_hengine_oil') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Look for any oil leaks around the engine</label>
                                 <select class="form-control selectbox" name="inspection_hengine_leak" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_hengine_leak == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_hengine_leak == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_hengine_leak == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_hengine_leak'))
                                 <small style="color: red">{{ $errors->first('inspection_hengine_leak') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Coolant</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect the coolant level in the reservoir</label>
                                    <select class="form-control selectbox" name="inspection_hcoolant_level" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_hcoolant_level == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_hcoolant_level == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_hcoolant_level == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_hcoolant_level'))
                                    <small style="color: red">{{ $errors->first('inspection_hcoolant_level') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Check for any signs of leaks around the radiator and hoses</label>
                                 <select class="form-control selectbox" name="inspection_hcoolant_leak" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_hcoolant_leak == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_hcoolant_leak == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_hcoolant_leak == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_hcoolant_leak'))
                                 <small style="color: red">{{ $errors->first('inspection_hcoolant_leak') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Brake Fluid</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check the brake fluid level in the master cylinder reservoir</label>
                                    <select class="form-control selectbox" name="inspection_hbrake_level" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_hbrake_level == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_hbrake_level == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_hbrake_level == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_hbrake_level'))
                                    <small style="color: red">{{ $errors->first('inspection_hbrake_level') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Inspect for any leaks around the brake lines</label>
                                 <select class="form-control selectbox" name="inspection_hbrake_leak" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_hbrake_leak == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_hbrake_leak == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_hbrake_leak == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_hbrake_leak'))
                                 <small style="color: red">{{ $errors->first('inspection_hbrake_leak') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Transmission Fluid</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check the transmission fluid level and condition</label>
                                    <select class="form-control selectbox" name="inspection_htrans_level" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_htrans_level == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_htrans_level == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_htrans_level == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_htrans_level'))
                                    <small style="color: red">{{ $errors->first('inspection_htrans_level') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Power Steering Fluid</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect the power steering fluid level</label>
                                    <select class="form-control selectbox" name="inspection_hpower_level" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_hpower_level == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_hpower_level == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_hpower_level == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_hpower_level'))
                                    <small style="color: red">{{ $errors->first('inspection_hpower_level') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Belts and Hoses</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check for cracks, fraying, or wear</label>
                                    <select class="form-control selectbox" name="inspection_hbelt_crack" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_hbelt_crack == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_hbelt_crack == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_hbelt_crack == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_hbelt_crack'))
                                    <small style="color: red">{{ $errors->first('inspection_hbelt_crack') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Ensure all hoses are securely attached and free of leaks</label>
                                    <select class="form-control selectbox" name="inspection_hbelt_hose" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_hbelt_hose == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_hbelt_hose == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_hbelt_hose == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_hbelt_hose'))
                                    <small style="color: red">{{ $errors->first('inspection_hbelt_hose') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Battery</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect the battery terminals for corrosion and ensure a secure connection</label>
                                    <select class="form-control selectbox" name="inspection_hbattery_terminal" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_hbattery_terminal == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_hbattery_terminal == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_hbattery_terminal == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_hbattery_terminal'))
                                    <small style="color: red">{{ $errors->first('inspection_hbattery_terminal') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check the battery charge level</label>
                                    <select class="form-control selectbox" name="inspection_hbattery_level" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_hbattery_level == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_hbattery_level == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_hbattery_level == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_hbattery_level'))
                                    <small style="color: red">{{ $errors->first('inspection_hbattery_level') }}</small>
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
                  <div class="tab-pane fade" id="tab5">
                     <div class="panel-body">
                        <form id="uvehicle_inspection_form" action="{{ url('admin/add_uvehicle_inspection/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="vehicle_id" value="{{ $inspection->inspection_vehicle }}">
                           <div class="row">
                              <div class="col-md-12">
                                 <h4>Exhaust System</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect for rust, damage, and leaks</label>
                                    <select class="form-control selectbox" name="inspection_vexhaust_rust" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_vexhaust_rust == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_vexhaust_rust == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_vexhaust_rust == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_vexhaust_rust'))
                                    <small style="color: red">{{ $errors->first('inspection_vexhaust_rust') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Ensure all hangers and brackets are secure</label>
                                 <select class="form-control selectbox" name="inspection_vexhaust_hanger" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_vexhaust_hanger == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_vexhaust_hanger == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_vexhaust_hanger == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_vexhaust_hanger'))
                                 <small style="color: red">{{ $errors->first('inspection_vexhaust_hanger') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Suspension and Steering</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check for any signs of wear or damage to the suspension components</label>
                                    <select class="form-control selectbox" name="inspection_vsuspension_wear" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_vsuspension_wear == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_vsuspension_wear == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_vsuspension_wear == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_vsuspension_wear'))
                                    <small style="color: red">{{ $errors->first('inspection_vsuspension_wear') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Ensure there is no excessive play in the steering</label>
                                 <select class="form-control selectbox" name="inspection_vsuspension_play" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_vsuspension_play == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_vsuspension_play == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_vsuspension_play == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_vsuspension_play'))
                                 <small style="color: red">{{ $errors->first('inspection_vsuspension_play') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Brakes</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect brake pads, rotors, and drums for wear</label>
                                    <select class="form-control selectbox" name="inspection_vbrake_pads" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_vbrake_pads == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_vbrake_pads == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_vbrake_pads == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_vbrake_pads'))
                                    <small style="color: red">{{ $errors->first('inspection_vbrake_pads') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check for any signs of brake fluid leaks</label>
                                    <select class="form-control selectbox" name="inspection_vbrake_leak" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_vbrake_leak == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_vbrake_leak == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_vbrake_leak == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_vbrake_leak'))
                                    <small style="color: red">{{ $errors->first('inspection_vbrake_leak') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Fluid Leaks</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Look for any signs of fluid leaks under the vehicle</label>
                                    <select class="form-control selectbox" name="inspection_vfluid_leak" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_vfluid_leak == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_vfluid_leak == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_vfluid_leak == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_vfluid_leak'))
                                    <small style="color: red">{{ $errors->first('inspection_vfluid_leak') }}</small>
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
                  <div class="tab-pane fade" id="tab6">
                     <div class="panel-body">
                        <form id="test_inspection_form" action="{{ url('admin/add_test_inspection/'.Request()->segment(3)) }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <input type="hidden" name="vehicle_id" value="{{ $inspection->inspection_vehicle }}">
                           <div class="row">
                              <div class="col-md-12">
                                 <h4>Engine Start</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Ensure the engine starts smoothly without unusual noises</label>
                                    <select class="form-control selectbox" name="inspection_tengine_start" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_tengine_start == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_tengine_start == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_tengine_start == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_tengine_start'))
                                    <small style="color: red">{{ $errors->first('inspection_tengine_start') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Listen for any abnormal sounds while the engine is running</label>
                                 <select class="form-control selectbox" name="inspection_tengine_sound" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_tengine_sound == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_tengine_sound == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_tengine_sound == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_tengine_sound'))
                                 <small style="color: red">{{ $errors->first('inspection_tengine_sound') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Brakes</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Test the brakes for proper function and response</label>
                                    <select class="form-control selectbox" name="inspection_tbrake_function" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_tbrake_function == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_tbrake_function == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_tbrake_function == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_tbrake_function'))
                                    <small style="color: red">{{ $errors->first('inspection_tbrake_function') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Ensure the parking brake holds the vehicle securely</label>
                                 <select class="form-control selectbox" name="inspection_tbrake_parking" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_tbrake_parking == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_tbrake_parking == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_tbrake_parking == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_tbrake_parking'))
                                 <small style="color: red">{{ $errors->first('inspection_tbrake_parking') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Steering</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Test the steering for smooth operation and response</label>
                                    <select class="form-control selectbox" name="inspection_tsteer_operation" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_tsteer_operation == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_tsteer_operation == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_tsteer_operation == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_tsteer_operation'))
                                    <small style="color: red">{{ $errors->first('inspection_tsteer_operation') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                 <label>Ensure there is no excessive play or unusual noises</label>
                                 <select class="form-control selectbox" name="inspection_tsteer_play" style="width: 95%">
                                    <option value="">Select</option>
                                    <option value="1" {{ $inspection->inspection_tsteer_play == 1 ? 'selected':'' }}>Satisfactory</option>
                                    <option value="2" {{ $inspection->inspection_tsteer_play == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                    <option value="3" {{ $inspection->inspection_tsteer_play == 3 ? 'selected':'' }}>N/A</option>
                                 </select>
                                 @if($errors->has('inspection_tsteer_play'))
                                 <small style="color: red">{{ $errors->first('inspection_tsteer_play') }}</small>
                                 @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Transmission</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Ensure smooth shifting through all gears</label>
                                    <select class="form-control selectbox" name="inspection_ttrans_gear" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_ttrans_gear == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_ttrans_gear == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_ttrans_gear == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_ttrans_gear'))
                                    <small style="color: red">{{ $errors->first('inspection_ttrans_gear') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check for any abnormal sounds or vibrations</label>
                                    <select class="form-control selectbox" name="inspection_ttrans_sound" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_ttrans_sound == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_ttrans_sound == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_ttrans_sound == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_ttrans_sound'))
                                    <small style="color: red">{{ $errors->first('inspection_ttrans_sound') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Winter</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check antifreeze levels</label>
                                    <select class="form-control selectbox" name="inspection_twinter_level" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_twinter_level == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_twinter_level == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_twinter_level == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_twinter_level'))
                                    <small style="color: red">{{ $errors->first('inspection_twinter_level') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Ensure heater and defroster work properly</label>
                                    <select class="form-control selectbox" name="inspection_twinter_heater" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_twinter_heater == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_twinter_heater == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_twinter_heater == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_twinter_heater'))
                                    <small style="color: red">{{ $errors->first('inspection_twinter_heater') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <h4>Summer</h4>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect air conditioning system</label>
                                    <select class="form-control selectbox" name="inspection_tsummer_air" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_tsummer_air == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_tsummer_air == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_tsummer_air == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_tsummer_air'))
                                    <small style="color: red">{{ $errors->first('inspection_tsummer_air') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Check coolant levels</label>
                                    <select class="form-control selectbox" name="inspection_tsummer_level" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_tsummer_level == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_tsummer_level == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_tsummer_level == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_tsummer_level'))
                                    <small style="color: red">{{ $errors->first('inspection_tsummer_level') }}</small>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Inspect tires for summer conditions</label>
                                    <select class="form-control selectbox" name="inspection_tsummer_condition" style="width: 95%">
                                       <option value="">Select</option>
                                       <option value="1" {{ $inspection->inspection_tsummer_condition == 1 ? 'selected':'' }}>Satisfactory</option>
                                       <option value="2" {{ $inspection->inspection_tsummer_condition == 2 ? 'selected':'' }}>Unsatisfactory</option>
                                       <option value="3" {{ $inspection->inspection_tsummer_condition == 3 ? 'selected':'' }}>N/A</option>
                                    </select>
                                    @if($errors->has('inspection_tsummer_condition'))
                                    <small style="color: red">{{ $errors->first('inspection_tsummer_condition') }}</small>
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