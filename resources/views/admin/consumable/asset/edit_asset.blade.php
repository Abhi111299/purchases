@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit Asset")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Edit Asset</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="asset_form" action="{{ url("admin/edit_asset/" . Request()->segment(3)) }}" method="post"
              enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Asset</label>
                    <input type="text" class="form-control" name="asset_name" value="{{ $asset->asset_name }}"
                      placeholder="Enter Asset" autocomplete="off">
                    @if ($errors->has("asset_name"))
                      <small style="color: red">{{ $errors->first("asset_name") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Method</label>
                    <select class="form-control selectbox" name="asset_method">
                      <option value="">Select</option>
                      @foreach ($activities as $activity)
                        <option value="{{ $activity->activity_id }}"
                          {{ $asset->asset_method == $activity->activity_id ? "selected" : "" }}>
                          {{ $activity->activity_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("asset_method"))
                      <small style="color: red">{{ $errors->first("asset_method") }}</small>
                    @endif
                    <span id="asset_method_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Location</label>
                    <select class="form-control selectbox" name="asset_location">
                      <option value="">Select</option>
                      @foreach ($locations as $location)
                        <option value="{{ $location->location_id }}"
                          {{ $asset->asset_location == $location->location_id ? "selected" : "" }}>
                          {{ $location->location_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("asset_location"))
                      <small style="color: red">{{ $errors->first("asset_location") }}</small>
                    @endif
                    <span id="asset_location_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Department</label>
                    <select class="form-control selectbox" name="asset_department">
                      <option value="">Select</option>
                      @foreach ($departments as $department)
                        <option value="{{ $department->department_id }}"
                          {{ $asset->asset_department == $department->department_id ? "selected" : "" }}>
                          {{ $department->department_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("asset_department"))
                      <small style="color: red">{{ $errors->first("asset_department") }}</small>
                    @endif
                    <span id="asset_department_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Condition</label>
                    <select class="form-control selectbox" name="asset_condition">
                      <option value="">Select</option>
                      <option value="1" {{ $asset->asset_condition == 1 ? "selected" : "" }}>Inservice</option>
                      <option value="2" {{ $asset->asset_condition == 2 ? "selected" : "" }}>Out of service</option>
                      <option value="3" {{ $asset->asset_condition == 3 ? "selected" : "" }}>Maintenance</option>
                      <option value="4" {{ $asset->asset_condition == 4 ? "selected" : "" }}>Calibration out
                      </option>
                      <option value="5" {{ $asset->asset_condition == 5 ? "selected" : "" }}>Repair</option>
                      <option value="6" {{ $asset->asset_condition == 6 ? "selected" : "" }}>Send for repair
                      </option>
                    </select>
                    @if ($errors->has("asset_condition"))
                      <small style="color: red">{{ $errors->first("asset_condition") }}</small>
                    @endif
                    <span id="asset_condition_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Manufacture</label>
                    <input type="text" class="form-control" name="asset_manufacture"
                      value="{{ $asset->asset_manufacture }}" placeholder="Enter Manufacture" autocomplete="off">
                    @if ($errors->has("asset_manufacture"))
                      <small style="color: red">{{ $errors->first("asset_manufacture") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" name="asset_model" value="{{ $asset->asset_model }}"
                      placeholder="Enter Model" autocomplete="off">
                    @if ($errors->has("asset_model"))
                      <small style="color: red">{{ $errors->first("asset_model") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Serial No</label>
                    <input type="text" class="form-control" name="asset_serial_no"
                      value="{{ $asset->asset_serial_no }}" placeholder="Enter Serial No" autocomplete="off">
                    @if ($errors->has("asset_serial_no"))
                      <small style="color: red">{{ $errors->first("asset_serial_no") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Calibration Required</label>
                    <select class="form-control selectbox" name="asset_crequired" id="asset_crequired"
                      onchange="select_calibration()">
                      <option value="">Select</option>
                      <option value="1" {{ $asset->asset_crequired == 1 ? "selected" : "" }}>Yes</option>
                      <option value="2" {{ $asset->asset_crequired == 2 ? "selected" : "" }}>No</option>
                    </select>
                    @if ($errors->has("asset_crequired"))
                      <small style="color: red">{{ $errors->first("asset_crequired") }}</small>
                    @endif
                    <span id="asset_crequired_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3 calibration_div"
                  @if ($asset->asset_crequired == 2) style="display: none" @endif>
                  <div class="form-group">
                    <label class="form-label">Calibration Date</label>
                    <input type="text" class="form-control" name="asset_cdate" id="asset_cdate"
                      @if (!empty($asset->asset_cdate)) value="{{ date("d-m-Y", strtotime($asset->asset_cdate)) }}" @endif
                      placeholder="Select Date" autocomplete="off">
                    @if ($errors->has("asset_cdate"))
                      <small style="color: red">{{ $errors->first("asset_cdate") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3 calibration_div"
                  @if ($asset->asset_crequired == 2) style="display: none" @endif>
                  <div class="form-group">
                    <label class="form-label">Calibration Frequency (in month)</label>
                    <input type="number" class="form-control" name="asset_cfrequency" id="asset_cfrequency"
                      value="{{ $asset->asset_cfrequency }}" placeholder="Enter Frequency" autocomplete="off"
                      onkeyup="select_due_date()">
                    @if ($errors->has("asset_cfrequency"))
                      <small style="color: red">{{ $errors->first("asset_cfrequency") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3 calibration_div"
                  @if ($asset->asset_crequired == 2) style="display: none" @endif>
                  <div class="form-group">
                    <label class="form-label">Calibration Due Date</label>
                    <input type="text" class="form-control" name="asset_cdue_date" id="asset_cdue_date"
                      @if (!empty($asset->asset_cdue_date)) value="{{ date("d-m-Y", strtotime($asset->asset_cdue_date)) }}" @endif
                      placeholder="Select Due Date" autocomplete="off" readonly>
                    @if ($errors->has("asset_cdue_date"))
                      <small style="color: red">{{ $errors->first("asset_cdue_date") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Accessory Included</label>
                    <select class="form-control selectbox" name="asset_accessory_include" id="asset_accessory_include"
                      onchange="select_accessory()">
                      <option value="">Select</option>
                      <option value="1" {{ $asset->asset_accessory_include == 1 ? "selected" : "" }}>Yes</option>
                      <option value="2" {{ $asset->asset_accessory_include == 2 ? "selected" : "" }}>No</option>
                    </select>
                    @if ($errors->has("asset_accessory_include"))
                      <small style="color: red">{{ $errors->first("asset_accessory_include") }}</small>
                    @endif
                    <span id="asset_accessory_include_error"></span>
                  </div>
                </div>
              </div>
              <div class="row accessory_section" @if ($asset->asset_accessory_include == 2) style="display: none" @endif>
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table " style="width: 100%">
                      <thead>
                        <tr class="info">
                          <td>Accessory</td>
                          <td>Model</td>
                          <td>Serial No</td>
                          <td>Action</td>
                        </tr>
                      </thead>
                      <tbody id="accessory_div">
                        @if (!empty($asset->asset_accessory_details))
                          @php $accessory_details = json_decode($asset->asset_accessory_details,true) @endphp
                          @foreach ($accessory_details["NAME"] as $key => $accessory_detail)
                            <tr id="accessory_div_{{ $loop->iteration }}">
                              <td>
                                <input type="text" name="accessory[NAME][{{ $loop->iteration }}]"
                                  class="form-control accessory_name" value="{{ $accessory_details["NAME"][$key] }}">
                              </td>
                              <td>
                                <input type="text" name="accessory[MODEL][{{ $loop->iteration }}]"
                                  class="form-control accessory_model" value="{{ $accessory_details["MODEL"][$key] }}">
                              </td>
                              <td>
                                <input type="text" name="accessory[SERIAL][{{ $loop->iteration }}]"
                                  class="form-control accessory_serial"
                                  value="{{ $accessory_details["SERIAL"][$key] }}">
                              </td>
                              <td>
                                @if ($loop->iteration == 1)
                                  <a href="javascript:void(0)" class="btn btn-primary" onclick="more_accessory()"><i
                                      class="fa fa-plus"></i></a>
                                @else
                                  <a href="javascript:void(0)" class="btn btn-danger"
                                    onclick="remove_accessory({{ $loop->iteration }})"><i class="fa fa-minus"></i></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr id="accessory_div_1">
                            <td>
                              <input type="text" name="accessory[NAME][1]" class="form-control accessory_name">
                            </td>
                            <td>
                              <input type="text" name="accessory[MODEL][1]" class="form-control accessory_model">
                            </td>
                            <td>
                              <input type="text" name="accessory[SERIAL][1]" class="form-control accessory_serial">
                            </td>
                            <td>
                              <a href="javascript:void(0)" class="btn btn-primary" onclick="more_accessory()"><i
                                  class="fa fa-plus"></i></a>
                            </td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Packing List/Delivery Note
                      @if (!empty($asset->asset_packing_file))
                        <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_packing_file) }}"
                          target="_blank">Click Here</a> to View Document
                      @endif
                    </label>
                    <input type="file" class="form-control" name="asset_packing_file">
                    @if ($errors->has("asset_packing_file"))
                      <small style="color: red">{{ $errors->first("asset_packing_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3 calibration_div"
                  @if ($asset->asset_crequired == 2) style="display: none" @endif>
                  <div class="form-group">
                    <label class="form-label">Manufacture Calibration
                      @if (!empty($asset->asset_manufacture_file))
                        <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_manufacture_file) }}"
                          target="_blank">Click Here</a> to View Document
                      @endif
                    </label>
                    <input type="file" class="form-control" name="asset_manufacture_file">
                    @if ($errors->has("asset_manufacture_file"))
                      <small style="color: red">{{ $errors->first("asset_manufacture_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">User Manual
                      @if (!empty($asset->asset_manual_file))
                        <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_manual_file) }}"
                          target="_blank">Click Here</a> to View Document
                      @endif
                    </label>
                    <input type="file" class="form-control" name="asset_manual_file">
                    @if ($errors->has("asset_manual_file"))
                      <small style="color: red">{{ $errors->first("asset_manual_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Supporting Files
                      @if (!empty($asset->asset_supporting_file))
                        <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_supporting_file) }}"
                          target="_blank">Click Here</a> to View Document
                      @endif
                    </label>
                    <input type="file" class="form-control" name="asset_supporting_file">
                    @if ($errors->has("asset_supporting_file"))
                      <small style="color: red">{{ $errors->first("asset_supporting_file") }}</small>
                    @endif
                  </div>
                </div>
                @php
                  $photographs_files = json_decode($asset->asset_photographs_file, true);
                @endphp
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Photographs
                      @if (!empty($asset->asset_photographs_file))
                        @foreach ($photographs_files as $photographs_file)
                          <div>
                            <a href="{{ asset(config("constants.admin_path") . "uploads/asset/" . $photographs_file) }}"
                              target="_blank">Click Here</a> to View Document
                          </div>
                        @endforeach
                      @endif
                    </label>
                    <input type="file" class="form-control" name="asset_photographs_file[]" accept="image/*"
                      multiple>
                    @if ($errors->has("asset_photographs_file"))
                      <small style="color: red">{{ $errors->first("asset_photographs_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Thumbnail Image</label>
                    <div>
                      @if (!empty($asset->asset_image))
                        <img src="{{ asset(config("constants.admin_path") . "uploads/asset/" . $asset->asset_image) }}"
                          id="asset_image_src" class="img-thumbnail" style="height: 100px" alt="">
                      @else
                        <img src="{{ asset(config("constants.admin_path") . "dist/img/no_image.jpeg") }}"
                          id="asset_image_src" class="img-thumbnail" style="height: 100px" alt="">
                      @endif
                    </div>
                    <input type="file" class="form-control" name="asset_image" id="asset_image">
                    @if ($errors->has("asset_image"))
                      <small style="color: red">{{ $errors->first("asset_image") }}</small>
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
      </div>
    </div>
  </section>
@endsection
@section("custom_script")
  <script>
    function select_calibration() {
      var crequired = $("#asset_crequired").val();

      $(".calibration_div").hide();

      if (crequired == 1) {
        $(".calibration_div").show();
      }
    }

    function select_accessory() {
      var arequired = $("#asset_accessory_include").val();

      $(".accessory_section").hide();

      if (arequired == 1) {
        $(".accessory_section").show();
      }
    }

    function select_due_date() {
      var calibration_date = $("#asset_cdate").val();
      var calibration_frequency = $("#asset_cfrequency").val();

      if (calibration_date != '' && calibration_frequency != '') {
        var csrf = "{{ csrf_token() }}";

        $.ajax({
          url: "{{ url("admin/select_due_date") }}",
          type: "post",
          data: "calibration_date=" + calibration_date + "&calibration_frequency=" + calibration_frequency +
            '&_token=' + csrf,
          success: function(data) {

            $("#asset_cdue_date").val(data);
          }
        });
      }
    }

    @if (!empty($asset->asset_accessory_details))
      var i = {{ count($accessory_details["NAME"]) }};
    @else
      var i = 2;
    @endif

    function more_accessory() {
      $("#accessory_div").append('<tr id="accessory_div_' + i + '"> <td> <input type="text" name="accessory[NAME][' + i +
        ']" class="form-control accessory_name"> </td> <td> <input type="text" name="accessory[MODEL][' + i +
        ']" class="form-control accessory_model"> </td> <td> <input type="text" name="accessory[SERIAL][' + i +
        ']" class="form-control accessory_serial"> </td> <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_accessory(' +
        i + ')"><i class="fa fa-minus"></i></a> </td> </tr>');

      i++;
    }

    function remove_accessory(val) {
      $("#accessory_div_" + val).remove();
    }

    $('#asset_cdate').datetimepicker({
      format: 'DD-MM-YYYY'
    }).on('dp.change', function(e) {
      select_due_date();
    });

    asset_image.onchange = evt => {
      const [file] = asset_image.files
      if (file) {
        asset_image_src.src = URL.createObjectURL(file)
      }
    }
  </script>
@endsection
