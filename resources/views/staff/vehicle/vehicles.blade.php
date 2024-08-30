@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Vehicles')
@section('contents')
<section class="content-header">
   <div class="header-title">
      <h1>Vehicles</h1>
   </div>
</section>
<section class="content">
   <div class="row">
      <div class="col-sm-12">
         <div class="panel panel-bd">
            <div class="panel-heading">
               <div class="btn-group" id="buttonexport">
                  <a href="javascript:void(0)">
                     <h4>Vehicles</h4>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table id="vehicle_table" class="table table-bordered table-striped table-hover" style="width: 100%">
                     <thead>
                        <tr class="info">
                           <th>#</th>
                           <th>Manufacturer</th>
                           <th>Model</th>
                           <th>Year</th>
                           <th>License Plate No</th>
                           <th>Driver</th>
                           <th>Start Odometer</th>
                           <th>Last Odometer</th>
                           <th>Total Kilometer Driven</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('custom_script')
<script>
var dataTable = $('#vehicle_table').DataTable({
	    processing: true,
	    serverSide: true,
       "pageLength": 20,
	    'ajax': {
	          type : 'POST',
	          url : "{{ url('staff/get_vehicles') }}",
	          'data': function(data){

	              var token =  "{{ csrf_token() }}";

	              data._token = token;
	          }
	    },
	    columns: [
	        {data: 'DT_RowIndex'},
	        {data: 'manufacturer_name'},
           {data: 'model_name'},
           {data: 'vehicle_year'},
	        {data: 'vehicle_license_no'},
           {data: 'staff_name'},
           {data: 'start_odometer'},
           {data: 'last_odometer'},
           {data: 'total_km'},
	        {data: 'action',orderable: false, searchable: false}
	    ]
});
</script>
@endsection