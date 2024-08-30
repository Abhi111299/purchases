@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Manufacturer")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h1 class="text-white">Add Manufacturers</h1>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="panel-heading">
            <!-- <div class="btn-group" id="buttonlist">Add Manufacturer</div> -->
          </div>
          <div class="card-body">
            <form id="manufacturer_form" action="{{ url("admin/add_manufacturer") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Manufacturer</label>
                    <input type="text" class="form-control" name="manufacturer_name"
                      value="{{ old("manufacturer_name") }}" placeholder="Enter Manufacturer" autocomplete="off">
                    @if ($errors->has("manufacturer_name"))
                      <small style="color: red">{{ $errors->first("manufacturer_name") }}</small>
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
