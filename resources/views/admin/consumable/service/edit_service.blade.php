@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit Service")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Edit Service</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            <form id="service_form" action="{{ url("admin/edit_service/" . Request()->segment(3)) }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label class="form-label">Service</label>
                    <input type="text" class="form-control" name="service_name" value="{{ $service->service_name }}"
                      placeholder="Enter Service" autocomplete="off">
                    @if ($errors->has("service_name"))
                      <small style="color: red">{{ $errors->first("service_name") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="service_desc" placeholder="Enter Description" autocomplete="off">{{ $service->service_desc }}</textarea>
                    @if ($errors->has("service_desc"))
                      <small style="color: red">{{ $errors->first("service_desc") }}</small>
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
