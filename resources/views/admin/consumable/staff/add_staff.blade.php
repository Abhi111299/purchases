@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Staff")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Add Staff</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="staff_form" action="{{ url("admin/add_staff") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Employee No</label>
                    <input type="text" class="form-control" name="staff_no" value="{{ old("staff_no") }}"
                      placeholder="Enter Employee No" autocomplete="off">
                    @if ($errors->has("staff_no"))
                      <small style="color: red">{{ $errors->first("staff_no") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Department</label>
                    <select class="form-control" name="staff_dept">
                      <option value="">Select</option>
                      @foreach ($departments as $department)
                        <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("staff_dept"))
                      <small style="color: red">{{ $errors->first("staff_dept") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Job Title</label>
                    <select class="form-control" name="staff_role">
                      <option value="">Select</option>
                      @foreach ($roles as $role)
                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                      @endforeach
                    </select>
                    @if ($errors->has("staff_role"))
                      <small style="color: red">{{ $errors->first("staff_role") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Job Status</label>
                    <select class="form-control" name="staff_job_type">
                      <option value="">Select</option>
                      <option value="1">Permanent</option>
                      <option value="2">Temporary</option>
                      <option value="3">Casual</option>
                      <option value="4">ABN</option>
                    </select>
                    @if ($errors->has("staff_job_type"))
                      <small style="color: red">{{ $errors->first("staff_job_type") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="staff_fname" value="{{ old("staff_fname") }}"
                      placeholder="Enter First Name" autocomplete="off">
                    @if ($errors->has("staff_fname"))
                      <small style="color: red">{{ $errors->first("staff_fname") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="staff_lname" value="{{ old("staff_lname") }}"
                      placeholder="Enter Last Name" autocomplete="off">
                    @if ($errors->has("staff_lname"))
                      <small style="color: red">{{ $errors->first("staff_lname") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="staff_email" value="{{ old("staff_email") }}"
                      placeholder="Enter Email" autocomplete="off">
                    @if ($errors->has("staff_email"))
                      <small style="color: red">{{ $errors->first("staff_email") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="staff_password" value="{{ old("staff_password") }}"
                      placeholder="Enter Password" autocomplete="off">
                    @if ($errors->has("staff_password"))
                      <small style="color: red">{{ $errors->first("staff_password") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Mobile</label>
                    <input type="text" class="form-control" name="staff_mobile" value="{{ old("staff_mobile") }}"
                      placeholder="Enter Mobile" autocomplete="off">
                    @if ($errors->has("staff_mobile"))
                      <small style="color: red">{{ $errors->first("staff_mobile") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="staff_phone" value="{{ old("staff_phone") }}"
                      placeholder="Enter Phone" autocomplete="off">
                    @if ($errors->has("staff_phone"))
                      <small style="color: red">{{ $errors->first("staff_phone") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">DOB</label>
                    <input type="text" class="form-control" name="staff_dob" id="staff_dob"
                      value="{{ old("staff_dob") }}" placeholder="Select DOB" autocomplete="off">
                    @if ($errors->has("staff_dob"))
                      <small style="color: red">{{ $errors->first("staff_dob") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Home Address</label>
                    <input type="text" class="form-control" name="staff_haddress"
                      value="{{ old("staff_haddress") }}" placeholder="Enter Home Address" autocomplete="off">
                    @if ($errors->has("staff_haddress"))
                      <small style="color: red">{{ $errors->first("staff_haddress") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Suburb</label>
                    <input type="text" class="form-control" name="staff_hsuburb"
                      value="{{ old("staff_hsuburb") }}" placeholder="Enter Suburb" autocomplete="off">
                    @if ($errors->has("staff_hsuburb"))
                      <small style="color: red">{{ $errors->first("staff_hsuburb") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">State</label>
                    <input type="text" class="form-control" name="staff_hstate" value="{{ old("staff_hstate") }}"
                      placeholder="Enter State" autocomplete="off">
                    @if ($errors->has("staff_hstate"))
                      <small style="color: red">{{ $errors->first("staff_hstate") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Post Code</label>
                    <input type="text" class="form-control" name="staff_hpost_code"
                      value="{{ old("staff_hpost_code") }}" placeholder="Enter Post Code" autocomplete="off">
                    @if ($errors->has("staff_hpost_code"))
                      <small style="color: red">{{ $errors->first("staff_hpost_code") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Overseas Address</label>
                    <input type="text" class="form-control" name="staff_oaddress"
                      value="{{ old("staff_oaddress") }}" placeholder="Enter Overseas Address" autocomplete="off">
                    @if ($errors->has("staff_oaddress"))
                      <small style="color: red">{{ $errors->first("staff_oaddress") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">State</label>
                    <input type="text" class="form-control" name="staff_ostate" value="{{ old("staff_ostate") }}"
                      placeholder="Enter State" autocomplete="off">
                    @if ($errors->has("staff_ostate"))
                      <small style="color: red">{{ $errors->first("staff_ostate") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Country</label>
                    <input type="text" class="form-control" name="staff_ocountry"
                      value="{{ old("staff_ocountry") }}" placeholder="Enter Country" autocomplete="off">
                    @if ($errors->has("staff_ocountry"))
                      <small style="color: red">{{ $errors->first("staff_ocountry") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="staff_ophone" value="{{ old("staff_ophone") }}"
                      placeholder="Enter Phone" autocomplete="off">
                    @if ($errors->has("staff_ophone"))
                      <small style="color: red">{{ $errors->first("staff_ophone") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Emergency contact : Name</label>
                    <input type="text" class="form-control" name="staff_ename" value="{{ old("staff_ename") }}"
                      placeholder="Enter Name" autocomplete="off">
                    @if ($errors->has("staff_ename"))
                      <small style="color: red">{{ $errors->first("staff_ename") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Relationship</label>
                    <input type="text" class="form-control" name="staff_erelationship"
                      value="{{ old("staff_erelationship") }}" placeholder="Enter Relationship" autocomplete="off">
                    @if ($errors->has("staff_erelationship"))
                      <small style="color: red">{{ $errors->first("staff_erelationship") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="staff_ephone" value="{{ old("staff_ephone") }}"
                      placeholder="Enter Phone" autocomplete="off">
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
                      <option value="1">Permanent Residency</option>
                      <option value="2">Citizen</option>
                      <option value="3">Temporary Visa</option>
                      <option value="4">Student Visa</option>
                      <option value="5">Other</option>
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
                      value="{{ old("staff_country") }}" placeholder="Enter Country of origin" autocomplete="off">
                    @if ($errors->has("staff_country"))
                      <small style="color: red">{{ $errors->first("staff_country") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Nationality</label>
                    <input type="text" class="form-control" name="staff_nationality"
                      value="{{ old("staff_nationality") }}" placeholder="Enter Nationality" autocomplete="off">
                    @if ($errors->has("staff_nationality"))
                      <small style="color: red">{{ $errors->first("staff_nationality") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Driving license Issued County</label>
                    <input type="text" class="form-control" name="staff_dlicense_country"
                      value="{{ old("staff_dlicense_country") }}" placeholder="Enter Driving license Issued County"
                      autocomplete="off">
                    @if ($errors->has("staff_dlicense_country"))
                      <small style="color: red">{{ $errors->first("staff_dlicense_country") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Superannuation Funds</label>
                    <input type="text" class="form-control" name="staff_sannuation_funds"
                      value="{{ old("staff_sannuation_funds") }}" placeholder="Enter Superannuation Funds"
                      autocomplete="off">
                    @if ($errors->has("staff_sannuation_funds"))
                      <small style="color: red">{{ $errors->first("staff_sannuation_funds") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <label class="form-label">Tax File No</label>
                    <input type="text" class="form-control" name="staff_tax_no" value="{{ old("staff_tax_no") }}"
                      placeholder="Enter Tax File No" autocomplete="off">
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
      </div>
    </div>
  </section>
@endsection
@section("custom_script")
  <script>
    $(function() {
      $('#staff_dob').datetimepicker({
        format: 'DD-MM-YYYY'
      });
    });
  </script>
@endsection
