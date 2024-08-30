@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Profile")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Profile</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                {{-- <a class="nav-link" href="#personal" data-toggle="tab">Personal Information</a> --}}
                <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal"
                  type="button" role="tab" aria-controls="personal" aria-selected="true">Personal
                  information</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" id="qualification-tab" data-bs-toggle="tab" data-bs-target="#qualification"
                  type="button" role="tab" aria-controls="qualification" aria-selected="false">Qualification</button>
                {{-- <a class="nav-link" href="#qualification" data-toggle="tab">Qualification</a> --}}
              </li>
              <li class="nav-item">
                <button class="nav-link" id="induction-tab" data-bs-toggle="tab" data-bs-target="#induction"
                  type="button" role="tab" aria-controls="induction" aria-selected="false">Safety Induction</button>
                {{-- <a class="nav-link" href="#induction" data-toggle="tab">Safety Induction</a> --}}
              </li>
              <li class="nav-item">
                <button class="nav-link" id="licence-tab" data-bs-toggle="tab" data-bs-target="#licence" type="button"
                  role="tab" aria-controls="licence" aria-selected="false">Safety Licence/Tickets</button>
                {{-- <a class="nav-link" href="#licence" data-toggle="tab">Safety Licence/Tickets</a> --}}
              </li>
              <li class="nav-item">
                <button class="nav-link" id="identification-tab" data-bs-toggle="tab" data-bs-target="#identification"
                  type="button" role="tab" aria-controls="identification"
                  aria-selected="false">Identification</button>
                {{-- <a class="nav-link" href="#identification" data-toggle="tab">Identification</a> --}}
              </li>
              <li class="nav-item">
                <button class="nav-link" id="document-tab" data-bs-toggle="tab" data-bs-target="#document" type="button"
                  role="tab" aria-controls="document" aria-selected="false">Documents</button>
                {{-- <a class="nav-link" href="#document" data-toggle="tab">Documents</a> --}}
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="personal" role="tabpanel" aria-labelledby="personal-tab" tabindex="0">
                <div class="card-body">
                  <form id="staff_form" action="{{ url("staff/profile") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Employee No</label>
                          <input type="text" class="form-control" value="{{ $staff->staff_no }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Department</label>
                          <input type="text" class="form-control" value="{{ $staff->department_name }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Job Title</label>
                          <input type="text" class="form-control" value="{{ $staff->role_name }}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Job Status</label>
                          @if ($staff->staff_job_type == 1)
                            <input type="text" class="form-control" value="Permanent" readonly>
                          @elseif($staff->staff_job_type == 2)
                            <input type="text" class="form-control" value="Temporary" readonly>
                          @elseif($staff->staff_job_type == 3)
                            <input type="text" class="form-control" value="Casual" readonly>
                          @elseif($staff->staff_job_type == 4)
                            <input type="text" class="form-control" value="ABN" readonly>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">First Name</label>
                          <input type="text" class="form-control" name="staff_fname"
                            value="{{ $staff->staff_fname }}" placeholder="Enter First Name" autocomplete="off">
                          @if ($errors->has("staff_fname"))
                            <small style="color: red">{{ $errors->first("staff_fname") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Last Name</label>
                          <input type="text" class="form-control" name="staff_lname"
                            value="{{ $staff->staff_lname }}" placeholder="Enter Last Name" autocomplete="off">
                          @if ($errors->has("staff_lname"))
                            <small style="color: red">{{ $errors->first("staff_lname") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Email</label>
                          <input type="email" class="form-control" name="staff_email"
                            value="{{ $staff->staff_email }}" placeholder="Enter Email" autocomplete="off">
                          @if ($errors->has("staff_email"))
                            <small style="color: red">{{ $errors->first("staff_email") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">DOB</label>
                          <input type="text" class="form-control" name="staff_dob" id="staff_dob"
                            value="{{ date("d-m-Y", strtotime($staff->staff_dob)) }}" placeholder="Select DOB"
                            autocomplete="off">
                          @if ($errors->has("staff_dob"))
                            <small style="color: red">{{ $errors->first("staff_dob") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Mobile</label>
                          <input type="text" class="form-control" name="staff_mobile"
                            value="{{ $staff->staff_mobile }}" placeholder="Enter Mobile" autocomplete="off">
                          @if ($errors->has("staff_mobile"))
                            <small style="color: red">{{ $errors->first("staff_mobile") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Phone</label>
                          <input type="text" class="form-control" name="staff_phone"
                            value="{{ $staff->staff_phone }}" placeholder="Enter Phone" autocomplete="off">
                          @if ($errors->has("staff_phone"))
                            <small style="color: red">{{ $errors->first("staff_phone") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Home Address</label>
                          <input type="text" class="form-control" name="staff_haddress"
                            value="{{ $staff->staff_haddress }}" placeholder="Enter Home Address" autocomplete="off">
                          @if ($errors->has("staff_haddress"))
                            <small style="color: red">{{ $errors->first("staff_haddress") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Suburb</label>
                          <input type="text" class="form-control" name="staff_hsuburb"
                            value="{{ $staff->staff_hsuburb }}" placeholder="Enter Suburb" autocomplete="off">
                          @if ($errors->has("staff_hsuburb"))
                            <small style="color: red">{{ $errors->first("staff_hsuburb") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">State</label>
                          <input type="text" class="form-control" name="staff_hstate"
                            value="{{ $staff->staff_hstate }}" placeholder="Enter State" autocomplete="off">
                          @if ($errors->has("staff_hstate"))
                            <small style="color: red">{{ $errors->first("staff_hstate") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Post Code</label>
                          <input type="text" class="form-control" name="staff_hpost_code"
                            value="{{ $staff->staff_hpost_code }}" placeholder="Enter Post Code" autocomplete="off">
                          @if ($errors->has("staff_hpost_code"))
                            <small style="color: red">{{ $errors->first("staff_hpost_code") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Overseas Address</label>
                          <input type="text" class="form-control" name="staff_oaddress"
                            value="{{ $staff->staff_oaddress }}" placeholder="Enter Overseas Address"
                            autocomplete="off">
                          @if ($errors->has("staff_oaddress"))
                            <small style="color: red">{{ $errors->first("staff_oaddress") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">State</label>
                          <input type="text" class="form-control" name="staff_ostate"
                            value="{{ $staff->staff_ostate }}" placeholder="Enter State" autocomplete="off">
                          @if ($errors->has("staff_ostate"))
                            <small style="color: red">{{ $errors->first("staff_ostate") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Country</label>
                          <input type="text" class="form-control" name="staff_ocountry"
                            value="{{ $staff->staff_ocountry }}" placeholder="Enter Country" autocomplete="off">
                          @if ($errors->has("staff_ocountry"))
                            <small style="color: red">{{ $errors->first("staff_ocountry") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Phone</label>
                          <input type="text" class="form-control" name="staff_ophone"
                            value="{{ $staff->staff_ophone }}" placeholder="Enter Phone" autocomplete="off">
                          @if ($errors->has("staff_ophone"))
                            <small style="color: red">{{ $errors->first("staff_ophone") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Emergency contact : Name</label>
                          <input type="text" class="form-control" name="staff_ename"
                            value="{{ $staff->staff_ename }}" placeholder="Enter Name" autocomplete="off">
                          @if ($errors->has("staff_ename"))
                            <small style="color: red">{{ $errors->first("staff_ename") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Relationship</label>
                          <input type="text" class="form-control" name="staff_erelationship"
                            value="{{ $staff->staff_erelationship }}" placeholder="Enter Relationship"
                            autocomplete="off">
                          @if ($errors->has("staff_erelationship"))
                            <small style="color: red">{{ $errors->first("staff_erelationship") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Phone</label>
                          <input type="text" class="form-control" name="staff_ephone"
                            value="{{ $staff->staff_ephone }}" placeholder="Enter Phone" autocomplete="off">
                          @if ($errors->has("staff_ephone"))
                            <small style="color: red">{{ $errors->first("staff_ephone") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Residence status</label>
                          <select class="form-control" name="staff_residence">
                            <option value="">Select</option>
                            <option value="1" {{ $staff->staff_residence == 1 ? "selected" : "" }}>Permanent
                              Residency</option>
                            <option value="2" {{ $staff->staff_residence == 2 ? "selected" : "" }}>Citizen</option>
                            <option value="3" {{ $staff->staff_residence == 3 ? "selected" : "" }}>Temporary Visa
                            </option>
                            <option value="4" {{ $staff->staff_residence == 4 ? "selected" : "" }}>Student Visa
                            </option>
                            <option value="5" {{ $staff->staff_residence == 5 ? "selected" : "" }}>Other</option>
                          </select>
                          @if ($errors->has("staff_residence"))
                            <small style="color: red">{{ $errors->first("staff_residence") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Country of origin</label>
                          <input type="text" class="form-control" name="staff_country"
                            value="{{ $staff->staff_country }}" placeholder="Enter Country of origin"
                            autocomplete="off">
                          @if ($errors->has("staff_country"))
                            <small style="color: red">{{ $errors->first("staff_country") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Nationality</label>
                          <input type="text" class="form-control" name="staff_nationality"
                            value="{{ $staff->staff_nationality }}" placeholder="Enter Nationality"
                            autocomplete="off">
                          @if ($errors->has("staff_nationality"))
                            <small style="color: red">{{ $errors->first("staff_nationality") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Driving license Issued County</label>
                          <input type="text" class="form-control" name="staff_dlicense_country"
                            value="{{ $staff->staff_dlicense_country }}"
                            placeholder="Enter Driving license Issued County" autocomplete="off">
                          @if ($errors->has("staff_dlicense_country"))
                            <small style="color: red">{{ $errors->first("staff_dlicense_country") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Superannuation Funds</label>
                          <input type="text" class="form-control" name="staff_sannuation_funds"
                            value="{{ $staff->staff_sannuation_funds }}" placeholder="Enter Superannuation Funds"
                            autocomplete="off">
                          @if ($errors->has("staff_sannuation_funds"))
                            <small style="color: red">{{ $errors->first("staff_sannuation_funds") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Image</label>
                          <div>
                            @if (!empty($staff->staff_image))
                              <img
                                src="{{ asset(config("constants.admin_path") . "uploads/profile/" . $staff->staff_image) }}"
                                id="staff_image_src" class="img-thumbnail" style="height: 200px">
                            @else
                              <img src="{{ asset(config("constants.admin_path") . "dist/img/no_image.png") }}"
                                id="staff_image_src" class="img-thumbnail" style="height: 200px">
                            @endif
                          </div>
                          <input type="file" class="form-control" id="staff_image" name="staff_image"
                            accept="image/*">
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Tax File No</label>
                          <input type="text" class="form-control" name="staff_tax_no"
                            value="{{ $staff->staff_tax_no }}" placeholder="Enter Tax File No" autocomplete="off">
                          @if ($errors->has("staff_tax_no"))
                            <small style="color: red">{{ $errors->first("staff_tax_no") }}</small>
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
              @php $education_detail = json_decode($staff->staff_education_details,true) @endphp
              <div class="tab-pane fade" id="qualification" role="tabpanel" aria-labelledby="qualification-tab"
                tabindex="0">
                <div class="card-body">
                  <form id="staff_qualification_form" action="{{ url("staff/add_staff_qualification") }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table " style="width: 100%">
                            <thead>
                              <tr class="info">
                                <td colspan="3" class="text-center">Education Details</td>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <input type="text" name="education_details[HDIPLOMA]" class="form-control"
                                    @if (isset($education_detail["HDIPLOMA"])) value="{{ $education_detail["HDIPLOMA"] }}" @endif
                                    placeholder="High School Diploma" autocomplete="off">
                                </td>
                                <td>
                                  <input type="text" name="education_details[HCOURSE]" class="form-control"
                                    @if (isset($education_detail["HCOURSE"])) value="{{ $education_detail["HCOURSE"] }}" @endif
                                    placeholder="Details of Course" autocomplete="off">
                                </td>
                                <td>
                                  <input type="text" name="education_details[HYEAR]"
                                    class="form-control education_year"
                                    @if (isset($education_detail["HYEAR"])) value="{{ $education_detail["HYEAR"] }}" @endif
                                    placeholder="Year of Completed" autocomplete="off">
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <input type="text" name="education_details[BDEGREE]" class="form-control"
                                    @if (isset($education_detail["BDEGREE"])) value="{{ $education_detail["BDEGREE"] }}" @endif
                                    placeholder="Bachelor’s Degree" autocomplete="off">
                                </td>
                                <td>
                                  <input type="text" name="education_details[BCOURSE]" class="form-control"
                                    @if (isset($education_detail["BCOURSE"])) value="{{ $education_detail["BCOURSE"] }}" @endif
                                    placeholder="Details of Course" autocomplete="off">
                                </td>
                                <td>
                                  <input type="text" name="education_details[BYEAR]"
                                    class="form-control education_year"
                                    @if (isset($education_detail["BYEAR"])) value="{{ $education_detail["BYEAR"] }}" @endif
                                    placeholder="Year of Completed" autocomplete="off">
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <input type="text" name="education_details[MDEGREE]" class="form-control"
                                    @if (isset($education_detail["MDEGREE"])) value="{{ $education_detail["MDEGREE"] }}" @endif
                                    placeholder="Master’s Degree" autocomplete="off">
                                </td>
                                <td>
                                  <input type="text" name="education_details[MCOURSE]" class="form-control"
                                    @if (isset($education_detail["MCOURSE"])) value="{{ $education_detail["MCOURSE"] }}" @endif
                                    placeholder="Details of Course" autocomplete="off">
                                </td>
                                <td>
                                  <input type="text" name="education_details[MYEAR]"
                                    class="form-control education_year"
                                    @if (isset($education_detail["MYEAR"])) value="{{ $education_detail["MYEAR"] }}" @endif
                                    placeholder="Year of Completed" autocomplete="off">
                                </td>
                              </tr>
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
                                <td>Certification Body</td>
                                <td>Certification Held</td>
                                <td>Level of Qualification</td>
                                <td>Certification Date</td>
                                <td>Expiry Date</td>
                                <td>Payment Status</td>
                                <td>Certificate Copy</td>
                                <td>Action</td>
                              </tr>
                            </thead>
                            <tbody id="certificate_div">
                              @if ($qualifications->count() > 0)
                                @foreach ($qualifications as $qualification)
                                  <tr id="certificate_div_{{ $loop->iteration }}">
                                    <td>
                                      <input type="text" name="certification_details[CBODY][{{ $loop->iteration }}]"
                                        class="form-control certificate_body"
                                        value="{{ $qualification->squalification_cbody }}"
                                        placeholder="Enter Certification Body">
                                    </td>
                                    <td>
                                      <input type="text" name="certification_details[CHELD][{{ $loop->iteration }}]"
                                        class="form-control certificate_held"
                                        value="{{ $qualification->squalification_held }}"
                                        placeholder="Enter Certification Held">
                                    </td>
                                    <td>
                                      <input type="text"
                                        name="certification_details[CLEVEL][{{ $loop->iteration }}]"
                                        class="form-control certificate_level"
                                        value="{{ $qualification->squalification_level }}"
                                        placeholder="Enter Level of Qualification">
                                    </td>
                                    <td>
                                      <input type="text" name="certification_details[CDATE][{{ $loop->iteration }}]"
                                        class="form-control certificate_date"
                                        value="{{ date("d-m-Y", strtotime($qualification->squalification_date)) }}"
                                        placeholder="Select Certification Date">
                                    </td>
                                    <td>
                                      <input type="text" name="certification_details[EDATE][{{ $loop->iteration }}]"
                                        class="form-control expiry_date"
                                        value="{{ date("d-m-Y", strtotime($qualification->squalification_edate)) }}"
                                        placeholder="Select Expiry Date">
                                    </td>
                                    <td>
                                      <select name="certification_details[PSTATUS][{{ $loop->iteration }}]"
                                        class="form-control selectbox pay_status" style="width: 100%;">
                                        <option value="">Select</option>
                                        <option value="1"
                                          {{ $qualification->squalification_pstatus == 1 ? "selected" : "" }}>Self
                                        </option>
                                        <option value="2"
                                          {{ $qualification->squalification_pstatus == 2 ? "selected" : "" }}>Company
                                        </option>
                                        <option value="3"
                                          {{ $qualification->squalification_pstatus == 3 ? "selected" : "" }}>Others
                                        </option>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="file" name="certification_details[FILE][{{ $loop->iteration }}]"
                                        class="form-control cerificate_file">
                                      <input type="hidden" name="certification_copy[{{ $loop->iteration }}]"
                                        value="{{ $qualification->squalification_copy }}">
                                      @if (!empty($qualification->squalification_copy))
                                        <div>
                                          <a href="{{ asset(config("constants.admin_path") . "uploads/staff/" . $qualification->squalification_copy) }}"
                                            target="_blank">Click Here</a> to view document
                                        </div>
                                      @endif
                                    </td>
                                    <td>
                                      @if ($loop->iteration == 1)
                                        <a href="javascript:void(0)" class="btn btn-primary"
                                          onclick="more_certification()"><i class="fa fa-plus"></i></a>
                                      @else
                                        <a href="javascript:void(0)" class="btn btn-danger"
                                          onclick="remove_certification({{ $loop->iteration }})"><i
                                            class="fa fa-minus"></i></a>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              @else
                                <tr id="certificate_div_1">
                                  <td>
                                    <input type="text" name="certification_details[CBODY][1]"
                                      class="form-control certificate_body" value=""
                                      placeholder="Enter Certification Body">
                                  </td>
                                  <td>
                                    <input type="text" name="certification_details[CHELD][1]"
                                      class="form-control certificate_held" value=""
                                      placeholder="Enter Certification Held">
                                  </td>
                                  <td>
                                    <input type="text" name="certification_details[CLEVEL][1]"
                                      class="form-control certificate_level" value=""
                                      placeholder="Enter Level of Qualification">
                                  </td>
                                  <td>
                                    <input type="text" name="certification_details[CDATE][1]"
                                      class="form-control certificate_date" value=""
                                      placeholder="Select Certification Date">
                                  </td>
                                  <td>
                                    <input type="text" name="certification_details[EDATE][1]"
                                      class="form-control expiry_date" value="" placeholder="Select Expiry Date">
                                  </td>
                                  <td>
                                    <select name="certification_details[PSTATUS][1]"
                                      class="form-control selectbox pay_status" style="width: 100%;">
                                      <option value="">Select</option>
                                      <option value="1">Self</option>
                                      <option value="2">Company</option>
                                      <option value="3">Others</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input type="file" name="certification_details[FILE][1]"
                                      class="form-control cerificate_file">
                                  </td>
                                  <td>
                                    <a href="javascript:void(0)" class="btn btn-primary"
                                      onclick="more_certification()"><i class="fa fa-plus"></i></a>
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
              <div class="tab-pane fade" id="induction" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <div class="card-body">
                  <form id="staff_induction_form" action="{{ url("staff/add_staff_induction") }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table " style="width: 100%">
                            <thead>
                              <tr class="info">
                                <td style="width: 200px">Client</td>
                                <td>Inducted Site</td>
                                <td>Name of Induction</td>
                                <td>Type of Induction</td>
                                <td>Induction Date</td>
                                <td>Expiry Date</td>
                                <td>Payment Status</td>
                                <td>Evidence of Induction</td>
                                <td>Action</td>
                              </tr>
                            </thead>
                            <tbody id="induction_div">
                              @if ($inductions->count() > 0)
                                @foreach ($inductions as $ikey => $induction)
                                  <tr id="induction_div_{{ $loop->iteration }}">
                                    <td>
                                      <select name="induction_details[CLIENT][{{ $loop->iteration }}]"
                                        class="form-control selectbox induction_client" style="width: 100%">
                                        <option value="">Select</option>
                                        @foreach ($customers as $customer)
                                          <option value="{{ $customer->customer_id }}"
                                            {{ $induction->sinduction_client == $customer->customer_id ? "selected" : "" }}>
                                            {{ $customer->customer_name }}</option>
                                        @endforeach
                                      </select>
                                    </td>
                                    <td>
                                      <input type="text" name="induction_details[SITE][{{ $loop->iteration }}]"
                                        class="form-control induction_site" value="{{ $induction->sinduction_site }}"
                                        placeholder="Enter Inducted Site" autocomplete="off">
                                    </td>
                                    <td>
                                      <input type="text" name="induction_details[NAME][{{ $loop->iteration }}]"
                                        class="form-control induction_name" value="{{ $induction->sinduction_name }}"
                                        placeholder="Enter Name of Induction" autocomplete="off">
                                    </td>
                                    <td>
                                      <select name="induction_details[TYPE][{{ $loop->iteration }}]"
                                        class="form-control induction_type">
                                        <option value="">Select</option>
                                        <option value="1" {{ $induction->sinduction_type == 1 ? "selected" : "" }}>
                                          Online</option>
                                        <option value="2" {{ $induction->sinduction_type == 2 ? "selected" : "" }}>
                                          Face to Face</option>
                                        <option value="3" {{ $induction->sinduction_type == 3 ? "selected" : "" }}>
                                          Other</option>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="text" name="induction_details[IDATE][{{ $loop->iteration }}]"
                                        class="form-control induction_date"
                                        value="{{ date("d-m-Y", strtotime($induction->sinduction_date)) }}"
                                        placeholder="Select Induction Date">
                                    </td>
                                    <td>
                                      <input type="text" name="induction_details[EDATE][{{ $loop->iteration }}]"
                                        class="form-control iexpiry_date"
                                        value="{{ date("d-m-Y", strtotime($induction->sinduction_edate)) }}"
                                        placeholder="Select Expiry Date">
                                    </td>
                                    <td>
                                      <select name="induction_details[PSTATUS][{{ $loop->iteration }}]"
                                        class="form-control selectbox ipay_status" style="width: 100%;">
                                        <option value="">Select</option>
                                        <option value="1"
                                          {{ $induction->sinduction_pstatus == 1 ? "selected" : "" }}>Self</option>
                                        <option value="2"
                                          {{ $induction->sinduction_pstatus == 2 ? "selected" : "" }}>Company</option>
                                        <option value="3"
                                          {{ $induction->sinduction_pstatus == 3 ? "selected" : "" }}>Others</option>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="file" name="induction_details[FILE][{{ $loop->iteration }}]"
                                        class="form-control induction_file">
                                      <input type="hidden" name="induction_evidence[{{ $loop->iteration }}]"
                                        value="{{ $induction->sinduction_copy }}">
                                      @if (!empty($induction->sinduction_copy))
                                        <div>
                                          <a href="{{ asset(config("constants.admin_path") . "uploads/staff/" . $induction->sinduction_copy) }}"
                                            target="_blank">Click Here</a> to view document
                                        </div>
                                      @endif
                                    </td>
                                    <td>
                                      @if ($loop->iteration == 1)
                                        <a href="javascript:void(0)" class="btn btn-primary"
                                          onclick="more_induction()"><i class="fa fa-plus"></i></a>
                                      @else
                                        <a href="javascript:void(0)" class="btn btn-danger"
                                          onclick="remove_induction({{ $loop->iteration }})"><i
                                            class="fa fa-minus"></i></a>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              @else
                                <tr id="induction_div_1">
                                  <td>
                                    <select name="induction_details[CLIENT][1]"
                                      class="form-control selectbox induction_client" style="width: 100%">
                                      <option value="">Select</option>
                                      @foreach ($customers as $customer)
                                        <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}
                                        </option>
                                      @endforeach
                                    </select>
                                  </td>
                                  <td>
                                    <input type="text" name="induction_details[SITE][1]"
                                      class="form-control induction_site" value=""
                                      placeholder="Enter Inducted Site" autocomplete="off">
                                  </td>
                                  <td>
                                    <input type="text" name="induction_details[NAME][1]"
                                      class="form-control induction_name" value=""
                                      placeholder="Enter Name of Induction" autocomplete="off">
                                  </td>
                                  <td>
                                    <select name="induction_details[TYPE][1]" class="form-control induction_type">
                                      <option value="">Select</option>
                                      <option value="1">Online</option>
                                      <option value="2">Face to Face</option>
                                      <option value="3">Other</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input type="text" name="induction_details[IDATE][1]"
                                      class="form-control induction_date" value=""
                                      placeholder="Select Induction Date">
                                  </td>
                                  <td>
                                    <input type="text" name="induction_details[EDATE][1]"
                                      class="form-control iexpiry_date" value=""
                                      placeholder="Select Expiry Date">
                                  </td>
                                  <td>
                                    <select name="induction_details[PSTATUS][1]"
                                      class="form-control selectbox ipay_status" style="width: 100%;">
                                      <option value="">Select</option>
                                      <option value="1">Self</option>
                                      <option value="2">Company</option>
                                      <option value="3">Others</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input type="file" name="induction_details[FILE][1]"
                                      class="form-control induction_file">
                                  </td>
                                  <td>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="more_induction()"><i
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
              <div class="tab-pane fade" id="licence" role="tabpanel" aria-labelledby="licence-tab" tabindex="0">
                <div class="card-body">
                  <form id="staff_licence_form" action="{{ url("staff/add_staff_licence") }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                          <table class="table " style="width: 100%">
                            <thead>
                              <tr class="info">
                                <td style="width: 200px">Training</td>
                                <td>Training Location</td>
                                <td>Training Organisation</td>
                                <td>Type of Training</td>
                                <td>Date of Validation</td>
                                <td>Expiry Date</td>
                                <td>Payment Status</td>
                                <td>Licence/ Ticket Copy</td>
                                <td>Action</td>
                              </tr>
                            </thead>
                            <tbody id="licence_div">
                              @if ($licences->count() > 0)
                                @foreach ($licences as $licence)
                                  <tr id="licence_div_{{ $loop->iteration }}">
                                    <td>
                                      <select name="validation_details[TRAINING][{{ $loop->iteration }}]"
                                        class="form-control selectbox validation_training" style="width: 100%">
                                        <option value="">Select</option>
                                        @foreach ($trainings as $training)
                                          <option value="{{ $training->training_id }}"
                                            {{ $training->training_id == $licence->slicence_training ? "selected" : "" }}>
                                            {{ $training->training_name }}</option>
                                        @endforeach
                                      </select>
                                    </td>
                                    <td>
                                      <input type="text"
                                        name="validation_details[LOCATION][{{ $loop->iteration }}]"
                                        class="form-control validation_location"
                                        value="{{ $licence->slicence_tlocation }}"
                                        placeholder="Enter Training Location" autocomplete="off">
                                    </td>
                                    <td>
                                      <input type="text"
                                        name="validation_details[ORGANISATION][{{ $loop->iteration }}]"
                                        class="form-control validation_organisation"
                                        value="{{ $licence->slicence_torganisation }}"
                                        placeholder="Enter Training Organisation" autocomplete="off">
                                    </td>
                                    <td>
                                      <select name="validation_details[TYPE][{{ $loop->iteration }}]"
                                        class="form-control validation_type">
                                        <option value="">Select</option>
                                        <option value="1"
                                          {{ $licence->slicence_training_type == 1 ? "selected" : "" }}>Online</option>
                                        <option value="2"
                                          {{ $licence->slicence_training_type == 2 ? "selected" : "" }}>Face to Face
                                        </option>
                                        <option value="3"
                                          {{ $licence->slicence_training_type == 3 ? "selected" : "" }}>Other</option>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="text" name="validation_details[VDATE][{{ $loop->iteration }}]"
                                        class="form-control validation_date"
                                        value="{{ date("d-m-Y", strtotime($licence->slicence_date)) }}"
                                        placeholder="Select Validation Date">
                                    </td>
                                    <td>
                                      <input type="text" name="validation_details[EDATE][{{ $loop->iteration }}]"
                                        class="form-control vexpiry_date"
                                        value="{{ date("d-m-Y", strtotime($licence->slicence_edate)) }}"
                                        placeholder="Select Expiry Date">
                                    </td>
                                    <td>
                                      <select name="validation_details[PSTATUS][{{ $loop->iteration }}]"
                                        class="form-control selectbox vpay_status" style="width: 100%;">
                                        <option value="">Select</option>
                                        <option value="1" {{ $licence->slicence_pstatus == 1 ? "selected" : "" }}>
                                          Self</option>
                                        <option value="2" {{ $licence->slicence_pstatus == 2 ? "selected" : "" }}>
                                          Company</option>
                                        <option value="3" {{ $licence->slicence_pstatus == 3 ? "selected" : "" }}>
                                          Others</option>
                                      </select>
                                    </td>
                                    <td>
                                      <input type="file" name="validation_details[FILE][{{ $loop->iteration }}]"
                                        class="form-control validation_file">
                                      <input type="hidden" name="licence_copy[{{ $loop->iteration }}]"
                                        value="{{ $licence->slicence_copy }}">
                                      @if (!empty($licence->slicence_copy))
                                        <div>
                                          <a href="{{ asset(config("constants.admin_path") . "uploads/staff/" . $licence->slicence_copy) }}"
                                            target="_blank">Click Here</a> to view document
                                        </div>
                                      @endif
                                    </td>
                                    <td>
                                      @if ($loop->iteration == 1)
                                        <a href="javascript:void(0)" class="btn btn-primary"
                                          onclick="more_licence()"><i class="fa fa-plus"></i></a>
                                      @else
                                        <a href="javascript:void(0)" class="btn btn-danger"
                                          onclick="remove_licence({{ $loop->iteration }})"><i
                                            class="fa fa-minus"></i></a>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              @else
                                <tr id="licence_div_1">
                                  <td>
                                    <select name="validation_details[TRAINING][1]"
                                      class="form-control selectbox validation_training" style="width: 100%">
                                      <option value="">Select</option>
                                      @foreach ($trainings as $training)
                                        <option value="{{ $training->training_id }}">{{ $training->training_name }}
                                        </option>
                                      @endforeach
                                    </select>
                                  </td>
                                  <td>
                                    <input type="text" name="validation_details[LOCATION][1]"
                                      class="form-control validation_location" value=""
                                      placeholder="Enter Training Location" autocomplete="off">
                                  </td>
                                  <td>
                                    <input type="text" name="validation_details[ORGANISATION][1]"
                                      class="form-control validation_organisation" value=""
                                      placeholder="Enter Training Organisation" autocomplete="off">
                                  </td>
                                  <td>
                                    <select name="validation_details[TYPE][1]" class="form-control validation_type">
                                      <option value="">Select</option>
                                      <option value="1">Online</option>
                                      <option value="2">Face to Face</option>
                                      <option value="3">Other</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input type="text" name="validation_details[VDATE][1]"
                                      class="form-control validation_date" value=""
                                      placeholder="Select Validation Date">
                                  </td>
                                  <td>
                                    <input type="text" name="validation_details[EDATE][1]"
                                      class="form-control vexpiry_date" value=""
                                      placeholder="Select Expiry Date">
                                  </td>
                                  <td>
                                    <select name="validation_details[PSTATUS][1]"
                                      class="form-control selectbox vpay_status" style="width: 100%;">
                                      <option value="">Select</option>
                                      <option value="1">Self</option>
                                      <option value="2">Company</option>
                                      <option value="3">Others</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input type="file" name="validation_details[FILE][1]"
                                      class="form-control validation_file">
                                  </td>
                                  <td>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="more_licence()"><i
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
              <div class="tab-pane fade" id="identification" role="tabpanel" aria-labelledby="identification-tab"
                tabindex="0">
                <div class="card-body">
                  <form id="staff_identification_form" action="{{ url("staff/add_staff_identification") }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Driving Licence : County of Issue</label>
                          <input type="text" class="form-control" name="staff_id_country"
                            value="{{ $staff->staff_id_country }}" placeholder="Enter County of Issue"
                            autocomplete="off">
                          @if ($errors->has("staff_id_country"))
                            <small style="color: red">{{ $errors->first("staff_id_country") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Expiry Date</label>
                          <input type="text" class="form-control" name="staff_id_expiry" id="staff_id_expiry"
                            @if (!empty($staff->staff_id_expiry)) value="{{ date("d-m-Y", strtotime($staff->staff_id_expiry)) }}" @endif
                            placeholder="Select Expiry Date" autocomplete="off">
                          @if ($errors->has("staff_id_expiry"))
                            <small style="color: red">{{ $errors->first("staff_id_expiry") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Type</label>
                          <select class="form-control selectbox" name="staff_id_type" style="width: 95%">
                            <option value="">Select</option>
                            <option value="1" {{ $staff->staff_id_type == 1 ? "selected" : "" }}>Automatic
                            </option>
                            <option value="2" {{ $staff->staff_id_type == 2 ? "selected" : "" }}>Manual</option>
                          </select>
                          @if ($errors->has("staff_dept"))
                            <small style="color: red">{{ $errors->first("staff_dept") }}</small>
                          @endif
                          <div id="staff_id_type_error"></div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Classification</label>
                          <select class="form-control selectbox" name="staff_id_classification" style="width: 95%">
                            <option value="">Select</option>
                            <option value="1" {{ $staff->staff_id_classification == 1 ? "selected" : "" }}>C Car
                            </option>
                            <option value="2" {{ $staff->staff_id_classification == 2 ? "selected" : "" }}>LR
                              Light
                              Rigid</option>
                            <option value="3" {{ $staff->staff_id_classification == 3 ? "selected" : "" }}>MR
                              Medium
                              Rigid</option>
                            <option value="4" {{ $staff->staff_id_classification == 4 ? "selected" : "" }}>HR
                              Heavy
                              Rigid</option>
                            <option value="5" {{ $staff->staff_id_classification == 5 ? "selected" : "" }}>HC
                              Heavy
                              Combination</option>
                            <option value="6" {{ $staff->staff_id_classification == 6 ? "selected" : "" }}>MC
                              Multi
                              Combination</option>
                            <option value="7" {{ $staff->staff_id_classification == 7 ? "selected" : "" }}>R-DATE
                            </option>
                            <option value="8" {{ $staff->staff_id_classification == 8 ? "selected" : "" }}>R
                              Motorcycle</option>
                          </select>
                          @if ($errors->has("staff_id_classification"))
                            <small style="color: red">{{ $errors->first("staff_id_classification") }}</small>
                          @endif
                          <div id="staff_id_classification_error"></div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Licence Copy
                            @if (!empty($staff->staff_id_copy))
                              <a href="{{ asset(config("constants.admin_path") . "uploads/staff/" . $staff->staff_id_copy) }}"
                                target="_blank">Click Here</a> to view document
                            @endif
                          </label>
                          <input type="file" class="form-control" name="staff_id_copy">
                          @if ($errors->has("staff_id_copy"))
                            <small style="color: red">{{ $errors->first("staff_id_copy") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Other ID : Name</label>
                          <input type="text" class="form-control" name="staff_id_other"
                            value="{{ $staff->staff_id_other }}" placeholder="Enter ID Name" autocomplete="off">
                          @if ($errors->has("staff_id_other"))
                            <small style="color: red">{{ $errors->first("staff_id_other") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Issued Authority</label>
                          <input type="text" class="form-control" name="staff_id_oissue"
                            value="{{ $staff->staff_id_oissue }}" placeholder="Enter Issued Authority"
                            autocomplete="off">
                          @if ($errors->has("staff_id_oissue"))
                            <small style="color: red">{{ $errors->first("staff_id_oissue") }}</small>
                          @endif
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-group">
                          <label class="form-label">Expiry Date</label>
                          <input type="text" class="form-control" name="staff_id_oexpiry" id="staff_id_oexpiry"
                            @if (!empty($staff->staff_id_oexpiry)) value="{{ date("d-m-Y", strtotime($staff->staff_id_oexpiry)) }}" @endif
                            placeholder="Select Expiry Date" autocomplete="off">
                          @if ($errors->has("staff_id_oexpiry"))
                            <small style="color: red">{{ $errors->first("staff_id_oexpiry") }}</small>
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
              @php $documents = json_decode($staff->staff_documents,true) @endphp
              <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab" tabindex="0">
                <div class="card-body">
                  <form id="staff_document_form" action="{{ url("staff/add_staff_document") }}" method="post"
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
                              @if (!empty($staff->staff_documents))
                                @php $documents = json_decode($staff->staff_documents,true) @endphp
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
                                        <a href="{{ asset(config("constants.admin_path") . "uploads/staff/" . $documents["FILE"][$dkey]) }}"
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
    @if ($qualifications->count() > 0)
      var i = {{ $qualifications->count() + 1 }};
    @else
      var i = 2;
    @endif

    function more_certification() {
      $("#certificate_div").append('<tr id="certificate_div_' + i +
        '"> <td><input type="text" name="certification_details[CBODY][' + i +
        ']" class="form-control certificate_body" value="" placeholder="Enter Certification Body"></td><td><input type="text" name="certification_details[CHELD][' +
        i +
        ']" class="form-control certificate_held" value="" placeholder="Enter Certification Held"></td><td><input type="text" name="certification_details[CLEVEL][' +
        i +
        ']" class="form-control certificate_level" value="" placeholder="Enter Level of Qualification"></td> <td> <input type="text" name="certification_details[CDATE][' +
        i +
        ']" class="form-control certificate_date" value="" placeholder="Select Certification Date"> </td> <td> <input type="text" name="certification_details[EDATE][' +
        i +
        ']" class="form-control expiry_date" value="" placeholder="Select Expiry Date"> </td> <td> <select name="certification_details[PSTATUS][' +
        i +
        ']" class="form-control selectbox pay_status" style="width: 100%;"> <option value="">Select</option> <option value="1">Self</option> <option value="2">Company</option> <option value="3">Others</option> </select> </td> <td> <input type="file" name="certification_details[FILE][' +
        i +
        ']" class="form-control cerificate_file"> </td> <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_certification(' +
        i + ')"><i class="fa fa-minus"></i></a> </td> </tr>');

      $('.certificate_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.expiry_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      i++;
    }

    function remove_certification(val) {
      $("#certificate_div_" + val).remove();
    }

    @if ($inductions->count() > 0)
      var j = {{ $inductions->count() + 1 }};
    @else
      var j = 2;
    @endif

    function more_induction() {
      $("#induction_div").append('<tr id="induction_div_' + j + '"> <td> <select name="induction_details[CLIENT][' + j +
        ']" class="form-control selectbox induction_client" style="width: 100%"> <option value="">Select</option> @foreach ($customers as $customer) <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option> @endforeach </select> </td> <td> <input type="text" name="induction_details[SITE][' +
        j +
        ']" class="form-control induction_site" value="" placeholder="Enter Inducted Site" autocomplete="off"> </td> <td> <input type="text" name="induction_details[NAME][' +
        j +
        ']" class="form-control induction_name" value="" placeholder="Enter Name of Induction" autocomplete="off"> </td> <td> <select name="induction_details[TYPE][' +
        j +
        ']" class="form-control induction_type"> <option value="">Select</option> <option value="1">Online</option> <option value="2">Face to Face</option> <option value="3">Other</option> </select> </td> <td> <input type="text" name="induction_details[IDATE][' +
        j +
        ']" class="form-control induction_date" value="" placeholder="Select Induction Date"> </td> <td> <input type="text" name="induction_details[EDATE][' +
        j +
        ']" class="form-control iexpiry_date" value="" placeholder="Select Expiry Date"> </td> <td> <select name="induction_details[PSTATUS][' +
        j +
        ']" class="form-control selectbox ipay_status" style="width: 100%;"> <option value="">Select</option> <option value="1">Self</option> <option value="2">Company</option> <option value="3">Others</option> </select> </td> <td> <input type="file" name="induction_details[FILE][' +
        j +
        ']" class="form-control induction_file"> </td> <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_induction(' +
        j + ')"><i class="fa fa-minus"></i></a> </td> </tr>');

      $('.selectbox').select2({
        theme: "bootstrap",
        placeholder: "Select"
      });

      $('.induction_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.iexpiry_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      j++;
    }

    function remove_induction(ival) {
      $("#induction_div_" + ival).remove();
    }

    @if ($licences->count() > 0)
      var k = {{ $licences->count() + 1 }};
    @else
      var k = 2;
    @endif

    function more_licence() {
      $("#licence_div").append('<tr id="licence_div_' + k + '"> <td> <select name="validation_details[TRAINING][' + k +
        ']" class="form-control selectbox validation_training" style="width: 100%"> <option value="">Select</option> @foreach ($trainings as $training) <option value="{{ $training->training_id }}">{{ $training->training_name }}</option> @endforeach </select> </td> <td> <input type="text" name="validation_details[LOCATION][' +
        k +
        ']" class="form-control validation_location" value="" placeholder="Enter Training Location" autocomplete="off"> </td> <td> <input type="text" name="validation_details[ORGANISATION][' +
        k +
        ']" class="form-control validation_organisation" value="" placeholder="Enter Training Organisation" autocomplete="off"> </td> <td> <select name="validation_details[TYPE][' +
        k +
        ']" class="form-control validation_type"> <option value="">Select</option> <option value="1">Online</option> <option value="2">Face to Face</option> <option value="3">Other</option> </select> </td> <td> <input type="text" name="validation_details[VDATE][' +
        k +
        ']" class="form-control validation_date" value="" placeholder="Select Validation Date"> </td> <td> <input type="text" name="validation_details[EDATE][' +
        k +
        ']" class="form-control vexpiry_date" value="" placeholder="Select Expiry Date"> </td> <td> <select name="validation_details[PSTATUS][' +
        k +
        ']" class="form-control selectbox vpay_status" style="width: 100%;"> <option value="">Select</option> <option value="1">Self</option> <option value="2">Company</option> <option value="3">Others</option> </select> </td> <td> <input type="file" name="validation_details[FILE][' +
        k +
        ']" class="form-control validation_file"> </td> <td> <a href="javascript:void(0)" class="btn btn-danger" onclick="remove_licence(' +
        k + ')"><i class="fa fa-minus"></i></a> </td> </tr>');

      $('.selectbox').select2({
        theme: "bootstrap",
        placeholder: "Select"
      });

      $('.validation_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.vexpiry_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      k++;
    }

    function remove_licence(ival) {
      $("#licence_div_" + ival).remove();
    }

    @if (!empty($staff->staff_documents))
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

    $(function() {
      $('#staff_dob').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.certificate_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.expiry_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.induction_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.iexpiry_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#staff_texpiry').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.validation_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('.vexpiry_date').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#staff_id_expiry').datetimepicker({
        format: 'DD-MM-YYYY'
      });

      $('#staff_id_oexpiry').datetimepicker({
        format: 'DD-MM-YYYY'
      });

    });

    $(function() {
      $('.education_year').datetimepicker({
        format: 'YYYY'
      });
    });

    $("#staff_qualification_form").submit(function(e) {

      $('.certificate_body').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Certification Body</small>'
          }
        });
      });

      $('.certificate_held').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Certification Held</small>'
          }
        });
      });

      $('.certificate_level').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Level of Qualification</small>'
          }
        });
      });

      $('.certificate_date').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Date</small>'
          }
        });
      });

      $('.expiry_date').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Date</small>'
          }
        });
      });

      $('.pay_status').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Status</small>'
          }
        });
      });

    });

    $("#staff_induction_form").submit(function(e) {

      $('.induction_client').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Client</small>'
          }
        });
      });

      $('.induction_site').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Site</small>'
          }
        });
      });

      $('.induction_name').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Name</small>'
          }
        });
      });

      $('.induction_type').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Type</small>'
          }
        });
      });

      $('.induction_date').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Date</small>'
          }
        });
      });

      $('.iexpiry_date').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Date</small>'
          }
        });
      });

      $('.ipay_status').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Status</small>'
          }
        });
      });

    });

    $("#staff_licence_form").submit(function(e) {

      $('.validation_training').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Training</small>'
          }
        });
      });

      $('.validation_location').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Location</small>'
          }
        });
      });

      $('.validation_organisation').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Organisation</small>'
          }
        });
      });

      $('.validation_type').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Type</small>'
          }
        });
      });

      $('.validation_date').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Date</small>'
          }
        });
      });

      $('.vexpiry_date').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Date</small>'
          }
        });
      });

      $('.vpay_status').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Select Status</small>'
          }
        });
      });

    });

    $("#staff_document_form").submit(function(e) {

      $('.document_name').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            required: '<small style="color:red">Please Enter Description</small>'
          }
        });
      });

    });

    staff_image.onchange = evt => {
      const [file] = staff_image.files
      if (file) {
        staff_image_src.src = URL.createObjectURL(file)
      }
    }
  </script>
@endsection
