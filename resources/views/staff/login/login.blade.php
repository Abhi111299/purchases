<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config("constants.site_title") }}</title>
  <link rel="shortcut icon" href="{{ asset(config("constants.admin_path") . "dist/img/ico/favicon.png") }}"
    type="image/x-icon">
  {{-- <link href="{{ asset(config("constants.admin_path") . "bootstrap/css/bootstrap.min.css") }}" rel="stylesheet"
    type="text/css"> --}}
  <link href="{{ mix("css/app.css") }}" rel="stylesheet">
  <link href="{{ asset(config("constants.admin_path") . "pe-icon-7-stroke/css/pe-icon-7-stroke.css") }}"
    rel="stylesheet" type="text/css">
  <link href="{{ asset(config("constants.admin_path") . "dist/css/stylecrm.css") }}" rel="stylesheet" type="text/css">
</head>

<body>
  <div class="login-wrapper">
    <div class="container-center">
      <div class="login-area">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <div class="d-flex align-items-center">
              <div class="fs-1 pe-3">
                <i class="pe-7s-unlock"></i>
              </div>
              <div>
                <h3 class="mb-0 card-title">Login</h3>
                <small>Please enter your credentials to login.</small>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form id="login_form" action="{{ url("staff") }}" method="post">
              @csrf
              <div class="form-group mb-3">
                <label class="form-label" for="staff_email">Email</label>
                <input type="text" name="staff_email" id="staff_email" class="form-control"
                  value="{{ old("staff_email") }}" placeholder="example@gmail.com" autocomplete="off">
                @if ($errors->has("staff_email"))
                  <small style="color:red">{{ $errors->first("staff_email") }}</small>
                @endif
              </div>
              <div class="form-group mb-3">
                <label class="form-label" for="staff_password">Password</label>
                <input type="password" name="staff_password" id="staff_password" class="form-control"
                  value="{{ old("staff_password") }}" placeholder="******" autocomplete="off">
                @if ($errors->has("staff_password"))
                  <small style="color:red">{{ $errors->first("staff_password") }}</small>
                @endif
              </div>
              <div class="g-0">
                <button type="submit" name="submit" class="btn btn-primary btn-block" value="submit">Login</button>
              </div>
              <div class="text-center">
                <a class="btn btn-link" href="{{ url("staff_forgot_password") }}">Forgot Password?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset(config("constants.admin_path") . "plugins/jQuery/jquery-1.12.4.min.js") }}"
    type="text/javascript"></script>
  <script src="{{ asset(config("constants.admin_path") . "bootstrap/js/bootstrap.min.js") }}" type="text/javascript">
  </script>
  <script src="{{ asset(config("constants.admin_path") . "dist/js/sweetalert.min.js") }}" type="text/javascript">
  </script>
  <script src="{{ asset(config("constants.admin_path") . "dist/js/jquery.validate.min.js") }}" type="text/javascript">
  </script>
  <script src="{{ asset(config("constants.admin_path") . "dist/js/staff_form_validations.js") }}" type="text/javascript">
  </script>
  <script>
    @if (Session::has("success"))
      swal("Success", "{{ Session::get("success") }}", "success");
    @endif
    @if (Session::has("error"))
      swal("Sorry", "{{ Session::get("error") }}", "warning");
    @endif
  </script>
</body>

</html>
