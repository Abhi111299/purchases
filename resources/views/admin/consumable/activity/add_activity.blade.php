@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Activity")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Activities</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="activity_form" action="{{ url("admin/add_activity") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label class="form-label">Activity</label>
                    <input type="text" class="form-control" name="activity_name" value="{{ old("activity_name") }}"
                      placeholder="Enter Activity" autocomplete="off">
                    @if ($errors->has("activity_name"))
                      <small style="color: red">{{ $errors->first("activity_name") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label class="form-label">Code</label>
                    <input type="text" class="form-control" name="activity_code" value="{{ old("activity_code") }}"
                      placeholder="Enter Code" autocomplete="off">
                    @if ($errors->has("activity_code"))
                      <small style="color: red">{{ $errors->first("activity_code") }}</small>
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
