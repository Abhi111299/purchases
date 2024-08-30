@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Department")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h1 class="text-white">Add Departments</h1>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="panel-heading">
            <!-- <div class="btn-group" id="buttonlist">Add Department</div> -->
          </div>
          <div class="card-body">
            <form id="department_form" action="{{ url("admin/add_department") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Department</label>
                    <input type="text" class="form-control" name="department_name" value="{{ old("department_name") }}"
                      placeholder="Enter Department" autocomplete="off">
                    @if ($errors->has("department_name"))
                      <small style="color: red">{{ $errors->first("department_name") }}</small>
                    @endif
                  </div>
                </div>
              </div>
              <div class="reset-button mt-2">
                <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
