@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Asset")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Add Asset</h4 class="text-white">
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="asset_form" action="{{ url("admin/add_asset") }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Asset</label>
                    <input type="text" class="form-control" name="asset_name" value="{{ old("asset_name") }}"
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
                        <option value="{{ $activity->activity_id }}">{{ $activity->activity_name }}</option>
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
                        <option value="{{ $location->location_id }}">{{ $location->location_name }}</option>
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
                        <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
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
                      <option value="1">Inservice</option>
                      <option value="2">Out of service</option>
                      <option value="3">Maintenance</option>
                      <option value="4">Calibration out</option>
                      <option value="5">Repair</option>
                      <option value="6">Send for repair</option>
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
                      value="{{ old("asset_manufacture") }}" placeholder="Enter Manufacture" autocomplete="off">
                    @if ($errors->has("asset_manufacture"))
                      <small style="color: red">{{ $errors->first("asset_manufacture") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" name="asset_model" value="{{ old("asset_model") }}"
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
                      value="{{ old("asset_serial_no") }}" placeholder="Enter Serial No" autocomplete="off">
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
                      <option value="1">Yes</option>
                      <option value="2" selected>No</option>
                    </select>
                    @if ($errors->has("asset_crequired"))
                      <small style="color: red">{{ $errors->first("asset_crequired") }}</small>
                    @endif
                    <span id="asset_crequired_error"></span>
                  </div>
                </div>
                <div class="col-md-6 mb-3 calibration_div" style="display: none">
                  <div class="form-group">
                    <label class="form-label">Calibration Date</label>
                    <input type="text" class="form-control" name="asset_cdate" id="asset_cdate"
                      value="{{ old("asset_cdate") }}" placeholder="Select Date" autocomplete="off">
                    @if ($errors->has("asset_cdate"))
                      <small style="color: red">{{ $errors->first("asset_cdate") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3 calibration_div" style="display: none">
                  <div class="form-group">
                    <label class="form-label">Calibration Frequency (in month)</label>
                    <input type="number" class="form-control" name="asset_cfrequency" id="asset_cfrequency"
                      value="{{ old("asset_cfrequency") }}" placeholder="Enter Frequency" autocomplete="off"
                      onkeyup="select_due_date()">
                    @if ($errors->has("asset_cfrequency"))
                      <small style="color: red">{{ $errors->first("asset_cfrequency") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3 calibration_div" style="display: none">
                  <div class="form-group">
                    <label class="form-label">Calibration Due Date</label>
                    <input type="text" class="form-control" name="asset_cdue_date" id="asset_cdue_date"
                      value="{{ old("asset_cdue_date") }}" placeholder="Select Due Date" autocomplete="off" readonly>
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
                      <option value="1">Yes</option>
                      <option value="2" selected>No</option>
                    </select>
                    @if ($errors->has("asset_accessory_include"))
                      <small style="color: red">{{ $errors->first("asset_accessory_include") }}</small>
                    @endif
                    <span id="asset_accessory_include_error"></span>
                  </div>
                </div>
              </div>
              <div class="row accessory_section" style="display: none">
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
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Packing List/Delivery Note</label>
                    <input type="file" class="form-control" name="asset_packing_file">
                    @if ($errors->has("asset_packing_file"))
                      <small style="color: red">{{ $errors->first("asset_packing_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3 calibration_div" style="display: none">
                  <div class="form-group">
                    <label class="form-label">Manufacture Calibration</label>
                    <input type="file" class="form-control" name="asset_manufacture_file">
                    @if ($errors->has("asset_manufacture_file"))
                      <small style="color: red">{{ $errors->first("asset_manufacture_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">User Manual</label>
                    <input type="file" class="form-control" name="asset_manual_file">
                    @if ($errors->has("asset_manual_file"))
                      <small style="color: red">{{ $errors->first("asset_manual_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Supporting Files</label>
                    <input type="file" class="form-control" name="asset_supporting_file">
                    @if ($errors->has("asset_supporting_file"))
                      <small style="color: red">{{ $errors->first("asset_supporting_file") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Photographs</label>
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
                      <img src="{{ asset(config("constants.admin_path") . "dist/img/no_image.jpeg") }}"
                        id="asset_image_src" class="img-thumbnail" style="height: 100px" alt="">
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

    var i = 2;

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
