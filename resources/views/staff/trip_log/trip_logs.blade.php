@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Trip Log')
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
                <div class="row">
                  <div class="col-md-6">
                     <div class="btn-group" id="buttonlist">Vehicles</div>
                  </div>
                  <div class="col-md-6 text-right">
                     <a href="{{ url('staff/vehicles') }}" class="btn btn-sm btn-success">Back</a>
                  </div>
                </div>
             </div>
             <div class="panel-body">
                <ul class="nav nav-tabs">
                  @include('staff.vehicle.vehicle_menu')
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade in active" id="tab1">
                     <div class="panel-body">
                        <div class="col-md-12">
                           <div class="form-group">
                              <a href="{{ url('staff/add_trip_log/'.Request()->segment(3)) }}" class="btn btn-exp btn-sm"><i class="fa fa-plus"></i> Add Trip Log</a>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                           <table id="trip_log_table" class="table table-bordered table-striped table-hover" style="width: 100%">
                              <thead>
                                 <tr class="info">
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Driver</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Start Odometer</th>
                                    <th>End Odometer</th>
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
          </div>
       </div>
    </div>
</section>
@endsection
@section('custom_script')
<script>
var dataTable = $('#trip_log_table').DataTable({
	    processing: true,
	    serverSide: true,
       "pageLength": 20,
	    'ajax': {
	          type : 'POST',
	          url : "{{ url('staff/get_trip_logs') }}",
	          'data': function(data){

	              var token = "{{ csrf_token() }}";
                 var vehicle_id = "{{ Request()->segment(3) }}";

	              data._token = token;
                 data.vehicle_id = vehicle_id;
	          }
	    },
	    columns: [
	        {data: 'DT_RowIndex'},
	        {data: 'trip_date'},
           {data: 'trip_log_driver'},
           {data: 'start_time'},
	        {data: 'end_time'},
           {data: 'trip_log_sodometer'},
           {data: 'trip_log_eodometer'},
	        {data: 'action',orderable: false, searchable: false}
	    ]
});

function confirm_msg(ev)
{	
   ev.preventDefault(); 

   var urlToRedirect = ev.currentTarget.getAttribute('href'); 

   swal({
        title: "Are you sure?",
        text: 'You want to change status!', 
        icon: "warning",
        buttons: true,
        dangerMode: true,            
        })
        .then((willChange) => {

          if (willChange) 
          {            
            window.location.href = urlToRedirect;
          }

        });
}
</script>
@endsection