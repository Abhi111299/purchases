@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Model")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h1 class="text-white">Add Models</h1>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="panel-heading">
            <!-- <div class="btn-group" id="buttonlist">Add Model</div> -->
          </div>
          <div class="card-body">
            <form id="model_form" action="{{ url("admin/add_model") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Manufacturer</label>
                    <select class="form-control selectbox" name="model_manufacturer">
                      <option value="">Select</option>
                      @foreach ($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->manufacturer_id }}">{{ $manufacturer->manufacturer_name }}
                        </option>
                      @endforeach
                    </select>
                    <div id="model_manufacturer_error"></div>
                    @if ($errors->has("model_manufacturer"))
                      <small style="color: red">{{ $errors->first("model_manufacturer") }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Model</label>
                    <input type="text" class="form-control" name="model_name" value="{{ old("model_name") }}"
                      placeholder="Enter Model" autocomplete="off">
                    @if ($errors->has("model_name"))
                      <small style="color: red">{{ $errors->first("model_name") }}</small>
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
