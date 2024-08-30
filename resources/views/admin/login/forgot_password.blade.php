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
                <i class="pe-7s-refresh-2"></i>
              </div>
              <div>
                <h3 class="mb-0 card-title">Forgot Password?</h3>
                <small><strong>Please fill the form to receive your password</strong></small>
              </div>
            </div>
          </div>
          <div class="card-body">
            <form id="forgot_form" action="{{ url("forgot_password") }}" method="post">
              @csrf
              <p>Fill with your mail to receive your password.</p>
              <div class="form-group mb-3">
                <label class="form-label" for="admin_email">Email</label>
                <input type="text" placeholder="example@gmail.com" title="Please enter you email adress"
                  value="{{ old("admin_email") }}" name="admin_email" id="admin_email" class="form-control">
                @if ($errors->has("admin_email"))
                  <small style="color:red">{{ $errors->first("admin_email") }}</small>
                @endif
              </div>
              <div>
                <button type="submit" name="submit" class="btn btn-primary btn-block" value="submit">Send</a>
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
  <script src="{{ asset(config("constants.admin_path") . "dist/js/form_validations.js") }}" type="text/javascript">
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
