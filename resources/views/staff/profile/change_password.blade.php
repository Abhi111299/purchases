@extends("staff.layouts.app")
@section("title", config("constants.site_title") . " | Change Password")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white mb-0">Change Password</h4>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card panel-bd">

          <div class="card-body">
            <form class="col-sm-12" id="password_form" action="{{ url("staff/change_password") }}" method="post">
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
    staff_image.onchange = evt => {
      const [file] = staff_image.files
      if (file) {
        staff_image_src.src = URL.createObjectURL(file)
      }
    }
  </script>
@endsection
