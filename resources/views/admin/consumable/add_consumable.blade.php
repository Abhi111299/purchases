@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Consumable")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h1 class="text-white">Add Consumables</h1>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="panel-heading">
            <!-- <div class="btn-group" id="buttonlist">Add Consumable</div> -->
          </div>
          <div class="card-body">
            <form id="consumable_form" action="{{ url("admin/add_consumable") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Consumable</label>
                    <input type="text" class="form-control" name="consumable_name" value="{{ old("consumable_name") }}"
                      placeholder="Enter Consumable" autocomplete="off">
                    @if ($errors->has("consumable_name"))
                      <small style="color: red">{{ $errors->first("consumable_name") }}</small>
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
