@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | View Job")
@section("custom_style")
  <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
    rel="stylesheet">
  <link rel="stylesheet" type="text/css"
    href="{{ asset(config("constants.admin_path") . "dist/css/jquery.signature.css") }}">
@endsection
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Job Card No - <b>{{ $booking->booking_job_id }}</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          {{-- <div class="panel-heading">
            <div class="btn-group" id="buttonlist">Job Card No - <b>{{ $booking->booking_job_id }}</b></div>
          </div> --}}
          <div class="card-body">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general"
                  type="button" role="tab" aria-controls="general" aria-selected="true">Home</button>
                {{-- <a class="nav-link" href="#general" data-toggle="tab">General</a> --}}
              </li>
              <li class="nav-item">
                <button class="nav-link" id="working-tab" data-bs-toggle="tab" data-bs-target="#working" type="button"
                  role="tab" aria-controls="working" aria-selected="false">Working Hours</button>
                {{-- <a class="nav-link" href="#working" data-toggle="tab">Working Hours</a> --}}
              </li>
              <li class="nav-item">
                <button class="nav-link" id="voucher-tab" data-bs-toggle="tab" data-bs-target="#voucher" type="button"
                  role="tab" aria-controls="voucher" aria-selected="false">Working Hours</button>
                {{-- <a class="nav-link" href="#voucher" data-toggle="tab">Voucher</a> --}}
              </li>
              <li class="nav-item">
                <button class="nav-link" id="photograph-tab" data-bs-toggle="tab" data-bs-target="#photograph"
                  type="button" role="tab" aria-controls="photograph" aria-selected="false">Working Hours</button>
                {{-- <a class="nav-link" href="#photograph" data-toggle="tab">Photographs</a> --}}
              </li>
              <li class="nav-item">
                <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button"
                  role="tab" aria-controls="upload" aria-selected="false">Working Hours</button>
                {{-- <a class="nav-link" href="#upload" data-toggle="tab">Upload</a> --}}
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="general">
                <div class="card-body">
                  <form action="{{ url("staff/update_booking_status/" . Request()->segment(3)) }}" method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Client</label>
                          <input type="text" class="form-control" value="{{ $booking->customer_name }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Activities</label>
                          <input type="text" class="form-control" value="{{ $activities }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Location</label>
                          <input type="text" class="form-control" value="{{ $booking->booking_lname }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Instruction</label>
                          <input type="text" class="form-control" value="{{ $booking->booking_instruction }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Status</label>
                          <select name="status" id="status" class="form-control selectbox" style="width: 95%;">
                            <option value="">Select</option>
                            <option value="1" {{ $booking->booking_status == 1 ? "selected" : "" }}>Pending</option>
                            <option value="2" {{ $booking->booking_status == 2 ? "selected" : "" }}>Cancelled
                            </option>
                            <option value="3" {{ $booking->booking_status == 3 ? "selected" : "" }}>Incomplete
                            </option>
                            <option value="4" {{ $booking->booking_status == 4 ? "selected" : "" }}>Report Pending
                            </option>
                            <option value="5" {{ $booking->booking_status == 5 ? "selected" : "" }}>Completed
                            </option>
                            <option value="6" {{ $booking->booking_status == 6 ? "selected" : "" }}>Rescheduled
                            </option>
                            <option value="7" {{ $booking->booking_status == 7 ? "selected" : "" }}>Client
                              Postponded
                            </option>
                            <option value="8" {{ $booking->booking_status == 8 ? "selected" : "" }}>Invoiced
                            </option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="upload">
                <div class="card-body">
                  <form action="{{ url("staff/upload_booking_files/" . Request()->segment(3)) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Worksheet
                            @if (!empty($booking->booking_worksheet))
                              <a href="{{ asset(config("constants.admin_path") . "uploads/booking/" . $booking->booking_worksheet) }}"
                                target="_blank">Click Here</a> to View Document
                            @endif
                          </label>
                          <input type="file" name="booking_worksheet" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Drawing
                            @if (!empty($booking->booking_drawing))
                              <a href="{{ asset(config("constants.admin_path") . "uploads/booking/" . $booking->booking_drawing) }}"
                                target="_blank">Click Here</a> to View Document
                            @endif
                          </label>
                          <input type="file" name="booking_drawing" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Final Request
                            @if (!empty($booking->booking_frequest))
                              <a href="{{ asset(config("constants.admin_path") . "uploads/booking/" . $booking->booking_frequest) }}"
                                target="_blank">Click Here</a> to View Document
                            @endif
                          </label>
                          <input type="file" name="booking_frequest" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="voucher">
                <div class="card-body">
                  <form id="voucher_form" action="{{ url("staff/update_voucher/" . Request()->segment(3)) }}"
                    method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Job Description</label>
                          <textarea class="form-control" name="booking_description" placeholder="Enter Job Description" style="width: 100%"
                            autocomplete="off">{{ $booking->booking_description }}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table " style="width: 100%">
                            <thead>
                              <tr class="info">
                                <td>Equipment</td>
                                <td>Qty</td>
                                <td>Action</td>
                              </tr>
                            </thead>
                            <tbody id="equipment_div">
                              @if (!empty($booking->booking_equipments))
                                @php $booking_equipments = json_decode($booking->booking_equipments,true) @endphp
                                @foreach ($booking_equipments["EQUIPMENT"] as $key => $booking_equipment)
                                  <tr id="equipment_div_{{ $loop->iteration }}">
                                    <td>
                                      <select name="equiments[EQUIPMENT][{{ $loop->iteration }}]"
                                        class="form-control selectbox equiments" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($equipments as $equipment)
                                          <option value="{{ $equipment->equipment_id }}"
                                            {{ $booking_equipments["EQUIPMENT"][$key] == $equipment->equipment_id ? "selected" : "" }}>
                                            {{ $equipment->equipment_name }}</option>
                                        @endforeach
                                      </select>
                                    </td>
                                    <td>
                                      <input type="number" name="equiments[QTY][{{ $loop->iteration }}]"
                                        class="form-control equiments_qty"
                                        value="{{ $booking_equipments["QTY"][$key] }}">
                                    </td>
                                    <td>
                                      @if ($loop->iteration == 1)
                                        <a href="javascript:void(0)" class="btn btn-primary"
                                          onclick="more_equipment()"><i class="fa fa-plus"></i></a>
                                      @else
                                        <a href="javascript:void(0)" class="btn btn-danger"
                                          onclick="remove_equipment({{ $loop->iteration }})"><i
                                            class="fa fa-minus"></i></a>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              @else
                                <tr id="equipment_div_1">
                                  <td>
                                    <select name="equiments[EQUIPMENT][1]" class="form-control selectbox equiments"
                                      style="width: 100%;">
                                      <option value="">Select</option>
                                      @foreach ($equipments as $equipment)
                                        <option value="{{ $equipment->equipment_id }}">{{ $equipment->equipment_name }}
                                        </option>
                                      @endforeach
                                    </select>
                                  </td>
                                  <td>
                                    <input type="number" name="equiments[QTY][1]" class="form-control equiments_qty"
                                      value="1">
                                  </td>
                                  <td>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="more_equipment()"><i
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
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table " style="width: 100%">
                            <thead>
                              <tr class="info">
                                <td>Consumable</td>
                                <td>Qty</td>
                                <td>Action</td>
                              </tr>
                            </thead>
                            <tbody id="consumable_div">
                              @if (!empty($booking->booking_consumables))
                                @php $booking_consumables = json_decode($booking->booking_consumables,true) @endphp
                                @foreach ($booking_consumables["CONSUMABLE"] as $ckey => $booking_consumable)
                                  <tr id="consumable_div_{{ $loop->iteration }}">
                                    <td>
                                      <select name="consumables[CONSUMABLE][{{ $loop->iteration }}]"
                                        class="form-control selectbox consumables" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($consumables as $consumable)
                                          <option value="{{ $consumable->consumable_id }}"
                                            {{ $booking_consumables["CONSUMABLE"][$ckey] == $consumable->consumable_id ? "selected" : "" }}>
                                            {{ $consumable->consumable_name }}</option>
                                        @endforeach
                                      </select>
                                    </td>
                                    <td>
                                      <input type="number" name="consumables[QTY][{{ $loop->iteration }}]"
                                        class="form-control consumables_qty"
                                        value="{{ $booking_consumables["QTY"][$ckey] }}">
                                    </td>
                                    <td>
                                      @if ($loop->iteration == 1)
                                        <a href="javascript:void(0)" class="btn btn-primary"
                                          onclick="more_consumable()"><i class="fa fa-plus"></i></a>
                                      @else
                                        <a href="javascript:void(0)" class="btn btn-danger"
                                          onclick="remove_consumable({{ $loop->iteration }})"><i
                                            class="fa fa-minus"></i></a>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              @else
                                <tr id="consumable_div_1">
                                  <td>
                                    <select name="consumables[CONSUMABLE][1]" class="form-control selectbox consumables"
                                      style="width: 100%;">
                                      <option value="">Select</option>
                                      @foreach ($consumables as $consumable)
                                        <option value="{{ $consumable->consumable_id }}">
                                          {{ $consumable->consumable_name }}</option>
                                      @endforeach
                                    </select>
                                  </td>
                                  <td>
                                    <input type="number" name="consumables[QTY][1]"
                                      class="form-control consumables_qty" value="1">
                                  </td>
                                  <td>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="more_consumable()"><i
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
                          <label class="form-label">Number of NATA Report</label>
                          <input type="number" name="booking_nata" class="form-control"
                            value="{{ $booking->booking_nata }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Number of Vehicles</label>
                          <input type="number" name="booking_nvehicles" class="form-control"
                            value="{{ $booking->booking_nvehicles }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Reporting Hours</label>
                          <input type="text" name="booking_rhours" class="form-control"
                            value="{{ $booking->booking_rhours }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Additional Expenses</label>
                          <input type="number" name="booking_aexpenses" class="form-control"
                            value="{{ $booking->booking_aexpenses }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Voucher Prepared By: Name</label>
                          <input type="text" name="booking_vname" class="form-control"
                            @if (!empty($booking->booking_vname)) value="{{ $booking->booking_vname }}" @else value="{{ Auth::guard("staff")->user()->staff_fname . " " . Auth::guard("staff")->user()->staff_lname }}" @endif
                            readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Email ID</label>
                          <input type="text" name="booking_vemail" class="form-control"
                            @if (!empty($booking->booking_vemail)) value="{{ $booking->booking_vemail }}" @else value="{{ Auth::guard("staff")->user()->staff_email }}" @endif
                            readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Phone</label>
                          <input type="text" name="booking_vphone" class="form-control"
                            @if (!empty($booking->booking_vphone)) value="{{ $booking->booking_vphone }}" @else value="{{ Auth::guard("staff")->user()->staff_phone }}" @endif
                            readonly>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Signature:</label>
                          <br />
                          <img
                            src="{{ asset(config("constants.admin_path") . "uploads/signature/" . $booking->booking_vsignature) }}"
                            alt="">
                          <br />
                          <div id="vsig"></div>
                          <br />
                          <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                          <textarea id="vsignature64" name="vsigned" style="display: none"></textarea>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Client Representative: Name</label>
                          <input type="text" name="booking_cname" class="form-control"
                            value="{{ $booking->booking_cname }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Email ID</label>
                          <input type="text" name="booking_cemail" class="form-control"
                            value="{{ $booking->booking_cemail }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Phone</label>
                          <input type="text" name="booking_cphone" class="form-control"
                            value="{{ $booking->booking_cphone }}" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Signature:</label>
                          <br />
                          <img
                            src="{{ asset(config("constants.admin_path") . "uploads/signature/" . $booking->booking_csignature) }}"
                            alt="">
                          <br />
                          <div id="csig"></div>
                          <br />
                          <button id="cclear" class="btn btn-danger btn-sm">Clear Signature</button>
                          <textarea id="csignature64" name="csigned" style="display: none"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="reset-button">
                      <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="tab-pane fade" id="working">
                <div class="card-body">
                  <div class="col-md-12">
                    <div class="form-group">
                      <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addWorkingModal"><i class="fa fa-plus"></i> Add Working Hour</a>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="table-responsive">
                    <table id="working_hour_table" class="table ">
                      <thead>
                        <tr class="info">
                          <th>#</th>
                          <th>Date</th>
                          <th>Technician</th>
                          <th>Left Base</th>
                          <th>Start Time</th>
                          <th>Finish Time</th>
                          <th>Return Base</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($working_hours as $working_hour)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date("d M Y", strtotime($working_hour->wh_date)) }}</td>
                            <td>{{ $working_hour->staff_fname . " " . $working_hour->staff_lname }}</td>
                            <td>{{ date("h:i A", strtotime($working_hour->wh_left_base)) }}</td>
                            <td>{{ date("h:i A", strtotime($working_hour->wh_start_time)) }}</td>
                            <td>{{ date("h:i A", strtotime($working_hour->wh_finish_time)) }}</td>
                            <td>{{ date("h:i A", strtotime($working_hour->wh_return_base)) }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              @php $files = json_decode($booking->booking_photographs,true); @endphp
              <div class="tab-pane fade" id="photograph">
                <div class="card-body">
                  <form action="{{ url("staff/upload_photographs/" . Request()->segment(3)) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Files
                            @if (!empty($booking->booking_photographs))
                              @foreach ($files as $file)
                                <div>
                                  <a href="{{ asset(config("constants.admin_path") . "uploads/booking/" . $file) }}"
                                    target="_blank">Click Here</a> to View Document {{ $loop->iteration }}
                                </div>
                              @endforeach
                            @endif
                          </label>
                          <input type="file" name="booking_photographs[]" class="form-control" multiple>
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
  <div class="modal fade" id="addWorkingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Working Hour</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="working_hour_form" action="{{ url("staff/add_working_hour/" . Request()->segment(3)) }}"
          method="post">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label class="form-label">Date</label>
                  <input type="text" class="form-control" name="wh_date" id="wh_date"
                    value="{{ date("d-m-Y") }}" placeholder="Enter Date" autocomplete="off">
                  @if ($errors->has("wh_date"))
                    <small style="color: red">{{ $errors->first("wh_date") }}</small>
                  @endif
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label class="form-label">Technician</label>
                  <select class="form-control selectbox" name="wh_technician" style="width: 100%">
                    <option value="">Select</option>
                    @foreach ($all_staffs as $all_staff)
                      <option value="{{ $all_staff->staff_id }}">
                        {{ $all_staff->staff_fname . " " . $all_staff->staff_lname }}</option>
                    @endforeach
                  </select>
                  @if ($errors->has("wh_technician"))
                    <small style="color: red">{{ $errors->first("wh_technician") }}</small>
                  @endif
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label class="form-label">Left Base</label>
                  <input type="text" class="form-control" name="wh_left_base" id="wh_left_base" value=""
                    placeholder="Select Left Base" autocomplete="off">
                  @if ($errors->has("wh_left_base"))
                    <small style="color: red">{{ $errors->first("wh_left_base") }}</small>
                  @endif
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label class="form-label">Return Base</label>
                  <input type="text" class="form-control" name="wh_return_base" id="wh_return_base" value=""
                    placeholder="Select Return Base" autocomplete="off">
                  @if ($errors->has("wh_return_base"))
                    <small style="color: red">{{ $errors->first("wh_return_base") }}</small>
                  @endif
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label class="form-label">Start Time</label>
                  <input type="text" class="form-control" name="wh_start_time" id="wh_start_time" value=""
                    placeholder="Select Start Time" autocomplete="off">
                  @if ($errors->has("wh_start_time"))
                    <small style="color: red">{{ $errors->first("wh_start_time") }}</small>
                  @endif
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <label class="form-label">Finish Time</label>
                  <input type="text" class="form-control" name="wh_finish_time" id="wh_finish_time" value=""
                    placeholder="Select Finish Time" autocomplete="off">
                  @if ($errors->has("wh_finish_time"))
                    <small style="color: red">{{ $errors->first("wh_finish_time") }}</small>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="submit" class="btn btn-add" value="submit">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section("custom_script")
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="{{ asset(config("constants.admin_path") . "dist/js/jquery.signature.js") }}">
  </script>
  <script>
    $('#working_hour_table').DataTable();

    @if (!empty($booking->booking_equipments))
      var i = {{ count($booking_equipments) + 1 }};
    @else
      var i = 2;
    @endif

    function more_equipment() {
      $("#equipment_div").append('<tr id="equipment_div_' + i + '"> <td> <select name="equiments[EQUIPMENT][' + i +
        ']" class="form-control selectbox equiments" style="width: 100%;"> <option value="">Select</option> @foreach ($equipments as $equipment) <option value="{{ $equipment->equipment_id }}">{{ $equipment->equipment_name }}</option> @endforeach </select> </td> <td> <input type="number" name="equiments[QTY][' +
        i +
        ']" class="form-control equiments_qty" value="1"> </td> <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_equipment(' +
        i + ')"><i class="fa fa-minus"></i></a> </td> </tr>');

      $('.selectbox').select2({
        theme: "bootstrap",
        placeholder: "Select"
      });

      i++;
    }

    function remove_equipment(val) {
      $("#equipment_div_" + val).remove();
    }

    @if (!empty($booking_consumables))
      var j = {{ count($booking_consumables) + 1 }};
    @else
      var j = 2;
    @endif

    function more_consumable() {
      $("#consumable_div").append('<tr id="consumable_div_' + j + '"> <td> <select name="consumables[CONSUMABLE][' + j +
        ']" class="form-control selectbox consumables" style="width: 100%;"> <option value="">Select</option> @foreach ($consumables as $consumable) <option value="{{ $consumable->consumable_id }}">{{ $consumable->consumable_name }}</option> @endforeach </select> </td> <td> <input type="number" name="consumables[QTY][' +
        j +
        ']" class="form-control consumables_qty" value="1"> </td> <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_consumable(' +
        j + ')"><i class="fa fa-minus"></i></a> </td> </tr>');

      $('.selectbox').select2({
        theme: "bootstrap",
        placeholder: "Select"
      });

      j++;
    }

    function remove_consumable(val) {
      $("#consumable_div_" + val).remove();
    }

    var sig = $('#vsig').signature({
      syncField: '#vsignature64',
      syncFormat: 'PNG'
    });
    $('#clear').click(function(e) {
      e.preventDefault();
      sig.signature('clear');
      $("#vsignature64").val('');
    });

    var csig = $('#csig').signature({
      syncField: '#csignature64',
      syncFormat: 'PNG'
    });
    $('#cclear').click(function(e) {
      e.preventDefault();
      csig.signature('clear');
      $("#csignature64").val('');
    });

    $("#voucher_form").submit(function(e) {

      $('.equiments').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Equipment</small>'
          }
        });
      });

      $('.equiments_qty').each(function() {
        $(this).rules('add', {
          required: true,
          number: true,
          messages: {
            required: '<small style="color:red">Please Enter Quantity</small>',
            number: '<small style="color:red">Please Enter Numbers Only</small>'
          }
        });
      });

      $('.consumables').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Equipment</small>'
          }
        });
      });

      $('.consumables_qty').each(function() {
        $(this).rules('add', {
          required: true,
          number: true,
          messages: {
            required: '<small style="color:red">Please Enter Quantity</small>',
            number: '<small style="color:red">Please Enter Numbers Only</small>'
          }
        });
      });

    });

    $('#wh_date').datetimepicker({
      format: 'DD-MM-YYYY'
    });

    $('#wh_left_base').datetimepicker({
      format: 'hh:mm A'
    });

    $('#wh_return_base').datetimepicker({
      format: 'hh:mm A'
    });

    $('#wh_start_time').datetimepicker({
      format: 'hh:mm A'
    });

    $('#wh_finish_time').datetimepicker({
      format: 'hh:mm A'
    });
  </script>
@endsection
