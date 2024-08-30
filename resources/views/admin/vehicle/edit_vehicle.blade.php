@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit Vehicle")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Edit Vehicle</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <ul class="nav nav-tabs">
              <li class="nav-items">
                <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail"
                  type="button" role="tab" aria-controls="detail" aria-selected="true">Details</button>
                {{-- <a href="#tab1" data-toggle="tab">Details</a> --}}
              </li>
              <li class="nav-items">
                <button class="nav-link" id="ownership-tab" data-bs-toggle="tab" data-bs-target="#ownership"
                  type="button" role="tab" aria-controls="ownership" aria-selected="false">Ownership and
                  Registration</button>
                {{-- <a href="#tab2" data-toggle="tab">Ownership and Registration</a> --}}
              </li>
              <li class="nav-items">
                <button class="nav-link" id="specification-tab" data-bs-toggle="tab" data-bs-target="#specification"
                  type="button" role="tab" aria-controls="specification"
                  aria-selected="false">Specifications</button>
                {{-- <a href="#tab3" data-toggle="tab">Specifications</a> --}}
              </li>
              <li class="nav-items">
                <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial"
                  type="button" role="tab" aria-controls="financial" aria-selected="false">Financial
                  Record</button>
                {{-- <a href="#tab4" data-toggle="tab">Financial Record</a> --}}
              </li>
              <li class="nav-items">
                <button class="nav-link" id="document-tab" data-bs-toggle="tab" data-bs-target="#document" type="button"
                  role="tab" aria-controls="document" aria-selected="false">Documents</button>
                {{-- <a href="#document" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0" data-toggle="tab">Documents</a> --}}
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="detail" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="card-body">
                  <form id="vehicle_form" action="{{ url("admin/edit_vehicle/" . Request()->segment(3)) }}"
                    method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Manufacturer</label>
                          <select class="form-control selectbox" name="vehicle_manufacturer" id="vehicle_manufacturer"
                            onchange="select_model()">
                            <option value="">Select</option>
                            @foreach ($manufacturers as $manufacturer)
                              <option value="{{ $manufacturer->manufacturer_id }}"
                                {{ $vehicle->vehicle_manufacturer == $manufacturer->manufacturer_id ? "selected" : "" }}>
                                {{ $manufacturer->manufacturer_name }}</option>
                            @endforeach
                          </select>
                          <div id="vehicle_manufacturer_error"></div>
                          @if ($errors->has("vehicle_manufacturer"))
                            <small style="color: red">{{ $errors->first("vehicle_manufacturer") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Model</label>
                          <select class="form-control selectbox" name="vehicle_model" id="vehicle_model">
                            <option value="">Select</option>
                            @foreach ($models as $model)
                              <option value="{{ $model->model_id }}"
                                {{ $vehicle->vehicle_model == $model->model_id ? "selected" : "" }}>
                                {{ $model->model_name }}
                              </option>
                            @endforeach
                          </select>
                          <div id="vehicle_model_error"></div>
                          @if ($errors->has("vehicle_model"))
                            <small style="color: red">{{ $errors->first("vehicle_model") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Year</label>
                          <input type="text" class="form-control" name="vehicle_year" id="vehicle_year"
                            value="{{ $vehicle->vehicle_year }}" placeholder="Select Year" autocomplete="off">
                          @if ($errors->has("vehicle_year"))
                            <small style="color: red">{{ $errors->first("vehicle_year") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">License Plate No</label>
                          <input type="text" class="form-control" name="vehicle_license_no"
                            value="{{ $vehicle->vehicle_license_no }}" placeholder="Enter License Plate No"
                            autocomplete="off">
                          @if ($errors->has("vehicle_license_no"))
                            <small style="color: red">{{ $errors->first("vehicle_license_no") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Vehicle Identification No</label>
                          <input type="text" class="form-control" name="vehicle_no"
                            value="{{ $vehicle->vehicle_no }}" placeholder="Enter Vehicle Identification No"
                            autocomplete="off">
                          @if ($errors->has("vehicle_no"))
                            <small style="color: red">{{ $errors->first("vehicle_no") }}</small>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="ownership" role="tabpanel" aria-labelledby="disabled-tab"
                tabindex="0">
                <div class="card-body">
                  <form id="vehicle_ownership_form"
                    action="{{ url("admin/add_vehicle_ownership/" . Request()->segment(3)) }}" method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Owner's Name</label>
                          <input type="text" class="form-control" name="vehicle_owner"
                            value="{{ $vehicle->vehicle_owner }}" placeholder="Enter Owner's Name" autocomplete="off">
                          @if ($errors->has("vehicle_owner"))
                            <small style="color: red">{{ $errors->first("vehicle_owner") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Address</label>
                          <input type="text" class="form-control" name="vehicle_address"
                            value="{{ $vehicle->vehicle_address }}" placeholder="Enter Address" autocomplete="off">
                          @if ($errors->has("vehicle_address"))
                            <small style="color: red">{{ $errors->first("vehicle_address") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Date of Registration</label>
                          <input type="text" class="form-control" name="vehicle_reg_date" id="vehicle_reg_date"
                            value="{{ $vehicle->vehicle_reg_date }}" placeholder="Select Date" autocomplete="off">
                          @if ($errors->has("vehicle_reg_date"))
                            <small style="color: red">{{ $errors->first("vehicle_reg_date") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Expiry Date</label>
                          <input type="text" class="form-control" name="vehicle_exp_date" id="vehicle_exp_date"
                            value="{{ $vehicle->vehicle_exp_date }}" placeholder="Select Date" autocomplete="off">
                          @if ($errors->has("vehicle_exp_date"))
                            <small style="color: red">{{ $errors->first("vehicle_exp_date") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Issuing Authority</label>
                          <input type="text" class="form-control" name="vehicle_authority"
                            value="{{ $vehicle->vehicle_authority }}" placeholder="Enter Issuing Authority"
                            autocomplete="off">
                          @if ($errors->has("vehicle_authority"))
                            <small style="color: red">{{ $errors->first("vehicle_authority") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">State</label>
                          <select class="form-control selectbox" name="vehicle_state" id="vehicle_state"
                            style="width: 95%">
                            <option value="">Select</option>
                            @foreach ($states as $state)
                              <option value="{{ $state->state_id }}"
                                {{ $vehicle->vehicle_state == $state->state_id ? "selected" : "" }}>
                                {{ $state->state_name }}</option>
                            @endforeach
                          </select>
                          <div id="vehicle_state_error"></div>
                          @if ($errors->has("vehicle_state"))
                            <small style="color: red">{{ $errors->first("vehicle_state") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Car Location</label>
                          <select class="form-control selectbox" name="vehicle_location" id="vehicle_location"
                            style="width: 95%">
                            <option value="">Select</option>
                            @foreach ($locations as $location)
                              <option value="{{ $location->location_id }}"
                                {{ $vehicle->vehicle_location == $location->location_id ? "selected" : "" }}>
                                {{ $location->location_name }}</option>
                            @endforeach
                          </select>
                          <div id="vehicle_location_error"></div>
                          @if ($errors->has("vehicle_location"))
                            <small style="color: red">{{ $errors->first("vehicle_location") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Assigned Driver</label>
                          <select class="form-control selectbox" name="vehicle_driver" id="vehicle_driver"
                            style="width: 95%">
                            <option value="">Select</option>
                            @foreach ($staffs as $staff)
                              <option value="{{ $staff->staff_id }}"
                                {{ $vehicle->vehicle_driver == $staff->staff_id ? "selected" : "" }}>
                                {{ $staff->staff_fname . " " . $staff->staff_mname . " " . $staff->staff_lname }}
                              </option>
                            @endforeach
                          </select>
                          <div id="vehicle_driver_error"></div>
                          @if ($errors->has("vehicle_driver"))
                            <small style="color: red">{{ $errors->first("vehicle_driver") }}</small>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="specification" role="tabpanel" aria-labelledby="disabled-tab"
                tabindex="0">
                <div class="card-body">
                  <form id="vehicle_specification_form"
                    action="{{ url("admin/add_vehicle_specification/" . Request()->segment(3)) }}" method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Engine Type</label>
                          <input type="text" class="form-control" name="vehicle_engine_type"
                            value="{{ $vehicle->vehicle_engine_type }}" placeholder="Enter Engine Type"
                            autocomplete="off">
                          @if ($errors->has("vehicle_engine_type"))
                            <small style="color: red">{{ $errors->first("vehicle_engine_type") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Transmission</label>
                          <select class="form-control selectbox" name="vehicle_transmission" id="vehicle_transmission"
                            style="width: 95%">
                            <option value="">Select</option>
                            <option value="1" {{ $vehicle->vehicle_transmission == 1 ? "selected" : "" }}>Automatic
                            </option>
                            <option value="2" {{ $vehicle->vehicle_transmission == 2 ? "selected" : "" }}>Manual
                            </option>
                          </select>
                          <div id="vehicle_transmission_error"></div>
                          @if ($errors->has("vehicle_transmission"))
                            <small style="color: red">{{ $errors->first("vehicle_transmission") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Fuel Type</label>
                          <select class="form-control selectbox" name="vehicle_fuel_type" id="vehicle_fuel_type"
                            style="width: 95%">
                            <option value="">Select</option>
                            <option value="1" {{ $vehicle->vehicle_fuel_type == 1 ? "selected" : "" }}>Gasoline
                            </option>
                            <option value="2" {{ $vehicle->vehicle_fuel_type == 2 ? "selected" : "" }}>Diesel
                            </option>
                            <option value="3" {{ $vehicle->vehicle_fuel_type == 3 ? "selected" : "" }}>Electric
                            </option>
                          </select>
                          <div id="vehicle_fuel_type_error"></div>
                          @if ($errors->has("vehicle_fuel_type"))
                            <small style="color: red">{{ $errors->first("vehicle_fuel_type") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Body Type</label>
                          <select class="form-control selectbox" name="vehicle_body_type" id="vehicle_body_type"
                            style="width: 95%">
                            <option value="">Select</option>
                            <option value="1" {{ $vehicle->vehicle_body_type == 1 ? "selected" : "" }}>Sedan
                            </option>
                            <option value="2" {{ $vehicle->vehicle_body_type == 2 ? "selected" : "" }}>UTE</option>
                            <option value="3" {{ $vehicle->vehicle_body_type == 3 ? "selected" : "" }}>Truck
                            </option>
                            <option value="4" {{ $vehicle->vehicle_body_type == 4 ? "selected" : "" }}>SUV</option>
                            <option value="5" {{ $vehicle->vehicle_body_type == 5 ? "selected" : "" }}>Coupe
                            </option>
                          </select>
                          <div id="vehicle_body_type_error"></div>
                          @if ($errors->has("vehicle_body_type"))
                            <small style="color: red">{{ $errors->first("vehicle_body_type") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Color</label>
                          <input type="text" class="form-control" name="vehicle_color"
                            value="{{ $vehicle->vehicle_color }}" placeholder="Enter Color" autocomplete="off">
                          @if ($errors->has("vehicle_color"))
                            <small style="color: red">{{ $errors->first("vehicle_color") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Odometer Reading</label>
                          <input type="text" class="form-control" name="vehicle_odometer_reading"
                            value="{{ $vehicle->vehicle_odometer_reading }}" placeholder="Enter Odometer Reading"
                            autocomplete="off">
                          @if ($errors->has("vehicle_odometer_reading"))
                            <small style="color: red">{{ $errors->first("vehicle_odometer_reading") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Features</label>
                          <input type="text" class="form-control" name="vehicle_features"
                            value="{{ $vehicle->vehicle_features }}" placeholder="Enter Features" autocomplete="off">
                          @if ($errors->has("vehicle_features"))
                            <small style="color: red">{{ $errors->first("vehicle_features") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Average Mileage/L</label>
                          <input type="text" class="form-control" name="vehicle_average_milegae"
                            value="{{ $vehicle->vehicle_average_milegae }}" placeholder="Enter Average Mileage/L"
                            autocomplete="off">
                          @if ($errors->has("vehicle_average_milegae"))
                            <small style="color: red">{{ $errors->first("vehicle_average_milegae") }}</small>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="financial" role="tabpanel" aria-labelledby="disabled-tab"
                tabindex="0">
                <div class="card-body">
                  <form id="vehicle_financial_form"
                    action="{{ url("admin/add_vehicle_financial/" . Request()->segment(3)) }}" method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Type</label>
                          <select class="form-control selectbox" name="vehicle_type" id="vehicle_type"
                            style="width: 95%">
                            <option value="">Select</option>
                            <option value="1" {{ $vehicle->vehicle_type == 1 ? "selected" : "" }}>Own</option>
                            <option value="2" {{ $vehicle->vehicle_type == 2 ? "selected" : "" }}>Loan</option>
                            <option value="3" {{ $vehicle->vehicle_type == 3 ? "selected" : "" }}>Lease</option>
                          </select>
                          <div id="vehicle_type_error"></div>
                          @if ($errors->has("vehicle_type"))
                            <small style="color: red">{{ $errors->first("vehicle_type") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Loan Amount</label>
                          <input type="text" class="form-control" name="vehicle_loan_amount"
                            value="{{ $vehicle->vehicle_loan_amount }}" placeholder="Enter Loan Amount"
                            autocomplete="off">
                          @if ($errors->has("vehicle_loan_amount"))
                            <small style="color: red">{{ $errors->first("vehicle_loan_amount") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Purchase Price</label>
                          <input type="text" class="form-control" name="vehicle_purchase_price"
                            value="{{ $vehicle->vehicle_purchase_price }}" placeholder="Enter Purchase Price"
                            autocomplete="off">
                          @if ($errors->has("vehicle_purchase_price"))
                            <small style="color: red">{{ $errors->first("vehicle_purchase_price") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Depreciation</label>
                          <input type="text" class="form-control" name="vehicle_depreciation"
                            value="{{ $vehicle->vehicle_depreciation }}" placeholder="Enter Depreciation"
                            autocomplete="off">
                          @if ($errors->has("vehicle_depreciation"))
                            <small style="color: red">{{ $errors->first("vehicle_depreciation") }}</small>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
              @php $documents = json_decode($vehicle->vehicle_documents,true) @endphp
              <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="disabled-tab"
                tabindex="0">
                <div class="card-body">
                  <form id="vehicle_document_form"
                    action="{{ url("admin/add_vehicle_document/" . Request()->segment(3)) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table " style="width: 100%">
                            <thead>
                              <tr class="info">
                                <td>Description</td>
                                <td>Document</td>
                                <td>Action</td>
                              </tr>
                            </thead>
                            <tbody id="document_div">
                              @if (!empty($vehicle->vehicle_documents))
                                @php $documents = json_decode($vehicle->vehicle_documents,true) @endphp
                                @foreach ($documents["NAME"] as $dkey => $document)
                                  <tr id="document_div_{{ $loop->iteration }}">
                                    <td>
                                      <input type="text" name="document[NAME][{{ $loop->iteration }}]"
                                        class="form-control document_name" value="{{ $documents["NAME"][$dkey] }}"
                                        placeholder="Enter Description">
                                    </td>
                                    <td>
                                      <input type="file" name="document[FILE][{{ $loop->iteration }}]"
                                        class="form-control document_file">
                                      <input type="hidden" name="documents[{{ $loop->iteration }}]"
                                        value="{{ $documents["FILE"][$dkey] }}">
                                      <div>
                                        <a href="{{ asset(config("constants.admin_path") . "uploads/vehicle/" . $documents["FILE"][$dkey]) }}"
                                          target="_blank">Click Here</a> to view document
                                      </div>
                                    </td>
                                    <td>
                                      @if ($loop->iteration == 1)
                                        <a href="javascript:void(0)" class="btn btn-primary"
                                          onclick="more_document()"><i class="fa fa-plus"></i></a>
                                      @else
                                        <a href="javascript:void(0)" class="btn btn-danger"
                                          onclick="remove_document({{ $loop->iteration }})"><i
                                            class="fa fa-minus"></i></a>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              @else
                                <tr id="document_div_1">
                                  <td>
                                    <input type="text" name="document[NAME][1]" class="form-control document_name"
                                      value="" placeholder="Enter Description">
                                  </td>
                                  <td>
                                    <input type="file" name="document[FILE][1]" class="form-control document_file">
                                  </td>
                                  <td>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="more_document()"><i
                                        class="fa fa-plus"></i></a>
                                  </td>
                                </tr>
                              @endif
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
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
@section("custom_script")
  <script>
    @if (!empty($vehicle->vehicle_documents))
      var d = {{ count($documents["NAME"]) + 1 }};
    @else
      var d = 2;
    @endif

    function more_document() {
      $("#document_div").append('<tr id="document_div_' + d + '"> <td> <input type="text" name="document[NAME][' + d +
        ']" class="form-control document_name" value="" placeholder="Enter Description"> </td> <td> <input type="file" name="document[FILE][' +
        d +
        ']" class="form-control document_file"> </td> <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_document(' +
        d + ')"><i class="fa fa-minus"></i></a> </td> </tr>');

      d++;
    }

    function remove_document(dval) {
      $("#document_div_" + dval).remove();
    }

    function select_model() {
      var manufacturer_id = $("#vehicle_manufacturer").val();

      var csrf = "{{ csrf_token() }}";

      $.ajax({
        url: "{{ url("admin/select_model") }}",
        type: "post",
        data: "manufacturer_id=" + manufacturer_id + '&_token=' + csrf,
        success: function(data) {

          $("#vehicle_model").html(data);
        }
      });
    }

    $(function() {
      $('#vehicle_year').datetimepicker({
        format: 'YYYY'
      });

      $('#vehicle_reg_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#vehicle_exp_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

    });

    $("#vehicle_document_form").submit(function(e) {

      $('.document_name').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Description</small>'
          }
        });
      });

    });
  </script>
@endsection
