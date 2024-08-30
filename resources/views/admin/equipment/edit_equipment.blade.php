@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit Equipment")
@section("contents")
  <section class="content-header">
    <div class="">
      <h4 class="text-white mb-0">Edit Equipments</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          {{-- <div class="panel-heading">
            <div class="btn-group" id="buttonlist">Edit Equipment</div>
          </div> --}}
          <div class="card-body">
            <form id="equipment_form" action="{{ url("admin/edit_equipment/" . Request()->segment(3)) }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label class="form-label">Equipment</label>
                    <input type="text" class="form-control" name="equipment_name"
                      value="{{ $equipment->equipment_name }}" placeholder="Enter Equipment" autocomplete="off">
                    @if ($errors->has("equipment_name"))
                      <small style="color: red">{{ $errors->first("equipment_name") }}</small>
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
