@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Profile")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Profile</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-6">
        <div class="card panel-bd">
          {{-- <div class="card-header">
            <div class="btn-group">Details</div>
          </div> --}}
          <div class="card-body">
            <form class="col-sm-12" id="profile_form" action="{{ url("admin/profile") }}" method="post"
              enctype="multipart/form-data">
              @csrf
              <div class="form-group mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="admin_name"
                  value="{{ Auth::guard("admin")->user()->admin_name }}" placeholder="Enter Name" autocomplete="off">
                @if ($errors->has("admin_name"))
                  <small style="color: red">{{ $errors->first("admin_name") }}</small>
                @endif
              </div>
              <div class="form-group mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="admin_email"
                  value="{{ Auth::guard("admin")->user()->admin_email }}" placeholder="Enter Email" autocomplete="off">
                @if ($errors->has("admin_email"))
                  <small style="color: red">{{ $errors->first("admin_email") }}</small>
                @endif
              </div>
              <div class="form-group mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="admin_phone"
                  value="{{ Auth::guard("admin")->user()->admin_phone }}" placeholder="Enter Phone" autocomplete="off">
                @if ($errors->has("admin_phone"))
                  <small style="color: red">{{ $errors->first("admin_phone") }}</small>
                @endif
              </div>
              <div class="form-group mb-3">
                <label class="form-label">Image</label>
                <div>
                  @if (!empty(Auth::guard("admin")->user()->admin_image))
                    <img
                      src="{{ asset(config("constants.admin_path") . "uploads/profile/" . Auth::guard("admin")->user()->admin_image) }}"
                      id="admin_image_src" class="img-thumbnail" style="height: 200px">
                  @else
                    <img src="{{ asset(config("constants.admin_path") . "dist/img/no_image.png") }}" class="img-thumbnail"
                      style="height: 200px">
                  @endif
                </div>
                <input type="file" id="admin_image" name="admin_image" accept="image/*">
              </div>
              <div class="reset-button">
                <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card panel-bd">
          {{-- <div class="panel-heading">
            <div class="btn-group" id="buttonlist">Change Password</div>
          </div> --}}
          <div class="card-body">
            <form class="col-sm-12" id="password_form" action="{{ url("admin/change_password") }}" method="post">
              @csrf
              <div class="form-group mb-3">
                <label class="form-label">Old Password</label>
                <input type="password" class="form-control" id="old_password" name="old_password"
                  value="{{ old("old_password") }}" placeholder="Enter Old Password" autocomplete="off">
                @if ($errors->has("old_password"))
                  <small style="color: red">{{ $errors->first("old_password") }}</small>
                @endif
              </div>
              <div class="form-group mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password"
                  value="{{ old("new_password") }}" placeholder="Enter New Password" autocomplete="off">
                @if ($errors->has("new_password"))
                  <small style="color: red">{{ $errors->first("new_password") }}</small>
                @endif
              </div>
              <div class="form-group mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                  value="{{ old("confirm_password") }}" placeholder="Enter Confirm Password" autocomplete="off">
                @if ($errors->has("confirm_password"))
                  <small style="color: red">{{ $errors->first("confirm_password") }}</small>
                @endif
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
    admin_image.onchange = evt => {
      const [file] = admin_image.files
      if (file) {
        admin_image_src.src = URL.createObjectURL(file)
      }
    }
  </script>
@endsection
