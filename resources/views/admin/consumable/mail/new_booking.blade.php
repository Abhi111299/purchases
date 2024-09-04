<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ config('constants.site_title') }} | New Job</title>
      <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css">
   </head>
   <body style="background-color: #f7f7f7; font-family: Poppins, sans-serif; line-height: 22px;">
      <div class="email-block" style="box-sizing: border-box; width: 560px; margin: 50px auto 0px; background-color: #fff; min-height: 550px; padding: 20px; border: 10px solid #ddd;">
         <h3 style="font-size: 13px;"></h3>
         <h3 style="background-color: #0585E8; padding: 20px; color: #fff; text-align: center;">Job Schedule for {{ $start_date }}</h3>
         <div class="pack" style="box-sizing: border-box; padding: 0px 15px;">
            <div class="pack-img" style="box-sizing: border-box; float: left;"></div>
            <div class="pack-details" style="box-sizing: border-box; padding-left: 20px; float: left; width: 100%;">
               <h3 style="font-size: 13px;">Hello,</h3>
               <h4 style="margin: 10px 0px 0px;">Job Card No<span style="color:#f04c23"> : <span>{{ $job_card_no }}</span></h4>
               <h4 style="margin: 10px 0px 0px;">Service<span style="color:#f04c23"> : <span>{{ $service_name }}</span></h4>
               <h4 style="margin: 10px 0px 0px;">Client<span style="color:#f04c23"> : <span>{{ $customer_name }}</span></h4>
               <h4 style="margin: 10px 0px 0px;">Start Date<span style="color:#f04c23"> : <span>{{ $start_date }}</span></h4>
               <h4 style="margin: 10px 0px 0px;">End Date<span style="color:#f04c23"> : <span>{{ $end_date }}</span></h4>
               <h4 style="margin: 10px 0px 0px;">Activities<span style="color:#f04c23"> : <span>{{ $activities }}</span></h4>
               <h4 style="margin: 10px 0px 0px;">Technicians<span style="color:#f04c23"> : <span>{{ $staffs }}</span></h4>
               @if(!empty($location_name))
               <h4 style="margin: 10px 0px 0px;">Location<span style="color:#f04c23"> : <a href="{{ $location_link }}"><span>{{ $location_name }}</span></a></h4>
               @endif
               @if(!empty($instructions))
               <h4 style="margin: 10px 0px 0px;">Instructions<span style="color:#f04c23"> : <span>{{ $instructions }}</span></h4>
               @endif
               <h4>Regards,</h4>
               <h4 style="margin: 10px 0px 0px;">{{ Auth::guard('admin')->user()->admin_name }}</h4>
               <h4 style="margin: 10px 0px 0px;">{{ Auth::guard('admin')->user()->admin_phone }}</h4>
               <h4 style="margin: 10px 0px 0px;">{{ Auth::guard('admin')->user()->admin_email }}</h4>
            </div>
         </div>
         <div class="clearfix" style="box-sizing: border-box; clear: both;"></div>
         <div class="text-center" style="box-sizing: border-box; text-align: center;">
         </div>
      </div>
   </body>
</html>