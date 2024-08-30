<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield("title")</title>
  @include("staff.partials.css")
  @yield("custom_style")
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    @include("staff.partials.header")
    @include("staff.partials.sidebar")
    <div class="content-wrapper">
      <div class="bg-primary" style="padding-bottom: 9.5rem !important;
  padding-top: 2rem; color:#fff"></div>
      <div class="container" style="margin-top:-10rem">
        @yield("contents")
      </div>
    </div>
    @include("staff.partials.footer")
  </div>
  @include("staff.partials.script")
  @yield("custom_script")
</body>

</html>
