@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Add Training")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h1 class="text-white">Add Trainings</h1>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          <div class="card-body">
            {{-- <div class="card-title">
              <div class="btn-group" id="buttonlist">Add Training</div>
            </div> --}}
            <form id="training_form" action="{{ url("admin/add_training") }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label class="form-label">Training</label>
                    <input type="text" class="form-control" name="training_name" value="{{ old("training_name") }}"
                      placeholder="Enter Training" autocomplete="off">
                    @if ($errors->has("training_name"))
                      <small style="color: red">{{ $errors->first("training_name") }}</small>
                    @endif
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
