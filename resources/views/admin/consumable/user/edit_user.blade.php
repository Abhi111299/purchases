@extends("admin.layouts.app")
@section("title", config("constants.site_title") . " | Edit User")
@section("contents")
  <section class="content-header">
    <div class="header-title">
      <h4 class="text-white">Edit User</h4>
    </div>
    <div class="card panel-bd">
      <div class="card-body">
        <form id="user_form" action="{{ url("admin/edit_user/" . Request()->segment(3)) }}" method="post"
          enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="admin_name" value="{{ $user->admin_name }}"
                  placeholder="Enter Name" autocomplete="off">
                @if ($errors->has("admin_name"))
                  <small style="color: red">{{ $errors->first("admin_name") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="admin_email" value="{{ $user->admin_email }}"
                  placeholder="Enter Email" autocomplete="off">
                @if ($errors->has("admin_email"))
                  <small style="color: red">{{ $errors->first("admin_email") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="admin_phone" value="{{ $user->admin_phone }}"
                  placeholder="Enter Phone" autocomplete="off">
                @if ($errors->has("admin_phone"))
                  <small style="color: red">{{ $errors->first("admin_phone") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="admin_password"
                  value="{{ base64_decode($user->admin_vpassword) }}" placeholder="Enter Password" autocomplete="off">
                @if ($errors->has("admin_password"))
                  <small style="color: red">{{ $errors->first("admin_password") }}</small>
                @endif
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Image</label>
                <div>
                  @if (!empty($user->admin_image))
                    <img src="{{ asset(config("constants.admin_path") . "uploads/profile/" . $user->admin_image) }}"
                      id="admin_image_src" class="img-thumbnail" style="height: 100px">
                  @else
                    <img src="{{ asset(config("constants.admin_path") . "dist/img/no_image.png") }}" id="admin_image_src"
                      class="img-thumbnail" style="height: 100px">
                  @endif
                </div>
                <input type="file" class="form-control" id="admin_image" name="admin_image">
                @if ($errors->has("admin_image"))
                  <small style="color: red">{{ $errors->first("admin_image") }}</small>
                @endif
              </div>
            </div>
            @php $modules_arr = json_decode($user->admin_modules); @endphp
            <div class="col-md-6 mb-3">
              <div class="form-group">
                <label class="form-label">Modules</label>
                <select class="form-control selectbox" name="admin_modules[]" multiple>
                  <option value="">Select</option>
                  @foreach ($modules as $module)
                    @if (in_array($module->module_id, $modules_arr))
                      <option value="{{ $module->module_id }}" selected>{{ $module->module_name }}</option>
                    @else
                      <option value="{{ $module->module_id }}">{{ $module->module_name }}</option>
                    @endif
                  @endforeach
                </select>
                @if ($errors->has("admin_modules"))
                  <small style="color: red">{{ $errors->first("admin_modules") }}</small>
                @endif
                <span id="admin_modules_error"></span>
              </div>
            </div>
          </div>
          <div class="reset-button">
            <button type="submit" name="submit" class="btn btn-primary" value="submit">Save</button>
          </div>
        </form>
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
