<header class="main-header">
  <a href="{{ url("admin/dashboard") }}" class="logo">
    <span class="logo-mini">
      <img src="{{ asset(config("constants.admin_path") . "dist/img/mini-logo.png") }}" alt=""
        class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">

    </span>
    <span class="logo-lg" style="color: white">
      {{-- <img src="{{ asset(config('constants.admin_path').'dist/img/logo.png') }}" alt=""> --}}
      {{ config("constants.site_title") }}
    </span>
  </a>
  <nav class="navbar navbar-static-top bg-white">
    <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
      <i class="lni lni-arrow-left-circle"></i>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown dropdown-user">
          <a href="javascript:void(0)" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            @if (!empty(Auth::guard("admin")->user()->admin_image))
              <img
                src="{{ asset(config("constants.admin_path") . "uploads/profile/" . Auth::guard("admin")->user()->admin_image) }}"
                class="img-thumbnail rounded-circle" style="width: 40px; height: 40px; object-fit: cover;"
                alt="user">
            @else
              <img src="{{ asset(config("constants.admin_path") . "dist/img/no_image.png") }}"
                class="img-thumbnail rounded-circle" style="width: 40px; height: 40px; object-fit: cover;"
                alt="user">
            @endif
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="{{ url("admin/profile") }}">
                <i class="fa fa-user"></i> Profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ url("admin/logout") }}">
                <i class="fa fa-sign-out"></i> Logout</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<script>
  const dropdownElementList = document.querySelectorAll('.dropdown-toggle')
  const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl))
</script>
