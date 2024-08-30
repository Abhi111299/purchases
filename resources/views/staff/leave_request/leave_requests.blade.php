@extends('staff.layouts.app')
@section('title',config('constants.site_title').' | Leave Requests')
@section('contents')
<section class="content-header">
   <div class="header-title">
      <h1>Leave Requests</h1>
   </div>
</section>
<section class="content">
   <div class="row">
      <div class="col-sm-12">
         <div class="panel panel-bd">
            <div class="panel-heading">
               <div class="btn-group" id="buttonexport">
                  <a href="javascript:void(0)">
                     <h4>Leave Requests</h4>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <div class="table-responsive">
                  <table id="leave_table" class="table table-bordered table-striped table-hover" style="width: 100%">
                     <thead>
                        <tr class="info">
                           <th>#</th>
                           <th>Staff</th>
                           <th>Type</th>
                           <th>Apply Date</th>
                           <th>Reason</th>
                           <th>Start Date</th>
                           <th>Return to Work</th>
                           <th>Status</th>
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
<div id="LeaveModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div>
</div>
@endsection
@section('custom_script')
<script>
var dataTable = $('#leave_table').DataTable({
	    processing: true,
	    serverSide: true,
       "pageLength": 20,
	    'ajax': {
	          type : 'POST',
	          url : "{{ url('staff/get_leave_requests') }}",
	          'data': function(data){

	              var token =  "{{ csrf_token() }}";

	              data._token = token;
	          }
	    },
	    columns: [
	        {data: 'DT_RowIndex'},
            {data: 'staff_name'},
	        {data: 'type'},
           {data: 'apply_date'},
           {data: 'leave_reason'},
           {data: 'start_date'},
           {data: 'return_date'},
           {data: 'status'},
	        {data: 'action',orderable: false, searchable: false}
	    ]
});

function leave_status(leave_id)
{
	var csrf = "{{ csrf_token() }}";

	$.ajax({
	    url: "{{ url('staff/leave_requests_status') }}",
	    type: "post",
	    data: "leave_id="+leave_id+'&_token='+csrf,
	    success: function (data) {

	    	$(".modal-content").html(data);
	    	$('#LeaveModal').modal('show');
	    }
	});
}

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