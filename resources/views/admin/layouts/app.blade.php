<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield("title")</title>
  @include("admin.partials.css")
  @yield("custom_style")

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    @include("admin.partials.header")
    @include("admin.partials.sidebar")
    <div class="content-wrapper ">
      <div class="bg-primary" style="padding-bottom: 9.5rem !important;
  padding-top: 2rem;"></div>
      <div class="container" style="margin-top:-10rem">
        @yield("contents")
      </div>
    </div>
    @include("admin.partials.footer")
  </div>
  @include("admin.partials.script")
  @yield("custom_script")
</body>

</html>
