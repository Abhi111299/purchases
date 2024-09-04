@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit Training")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h1 class="text-white">Edit Trainings</h1>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">
          {{-- <div class="panel-heading">
            <div class="btn-group" id="buttonlist">Edit Training</div>
          </div> --}}
          <div class="card-body">
            <form id="training_form" action="{{ url("admin/edit_training/" . Request()->segment(3)) }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-12 mb-3">
                  <div class="form-group">
                    <label class="form-label">Training</label>
                    <input type="text" class="form-control" name="training_name" value="{{ $training->training_name }}"
                      placeholder="Enter Training" autocomplete="off">
                    @if ($errors->has("training_name"))
                      <small style="color: red">{{ $errors->first("training_name") }}</small>
                    @endif
                  </div>
                </div>
              </div>
              <div class="reset-button">
                <button type="submit" name="submit" class="btn btn-primary" value="submit">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
