<script src="{{ asset(config('constants.admin_path').'plugins/jQuery/jquery-1.12.4.min.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset(config('constants.admin_path').'bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="{{ asset(config('constants.admin_path').'plugins/lobipanel/lobipanel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/pace/pace.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/fastclick/fastclick.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'dist/js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/chartJs/Chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/counterup/waypoints.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/monthly/monthly.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset(config('constants.admin_path').'plugins/datatables/dataTables.min.js') }}" type="text/javascript"></script> -->
<script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/datatables/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/datatables/buttons.print.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'dist/js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'dist/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'dist/js/select2.min.js') }}"></script>
<script src="{{ asset(config('constants.admin_path').'dist/js/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'dist/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset(config('constants.admin_path').'dist/js/staff_form_validations.js') }}" type="text/javascript"></script>
<script src="{{ asset(config("constants.admin_path") . "plugins/datatables/dataTables.min.custom.js") }}"
  type="text/javascript"></script>
<script>
$('.selectbox').select2({
    theme: "bootstrap",
	placeholder: "Select"
});

@if(Session::has('success'))
swal("Success", "{{ Session::get('success') }}", "success");
@endif
@if(Session::has('error'))
swal("Sorry", "{{ Session::get('error') }}", "warning");    
@endif
</script>