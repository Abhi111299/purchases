<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ config('constants.site_title') }} | Purchase Order</title>
      <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" type="text/css">
      <style>
         .button {
         background-color: #04AA6D; /* Green */
         border: none;
         color: white;
         padding: 7px 7px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 4px 2px;
         cursor: pointer;
         }

         .button2 {background-color: #008CBA;} /* Blue */
         .button3 {background-color: #f44336;} /* Red */ 
         .button4 {background-color: #e7e7e7; color: black;} /* Gray */ 
         .button5 {background-color: #555555;} /* Black */
         .button-approve { background-color: #4CAF50; } /* Green */
         .button-reject { background-color: #f44336; } /* Red */
      </style>
   </head>
   <body style="background-color: #f7f7f7; font-family: Poppins, sans-serif; line-height: 22px;">
      <div class="email-block" style="box-sizing: border-box; width: 560px; margin: 50px auto 0px; background-color: #fff; min-height: 550px; padding: 20px; border: 10px solid #ddd;">
         <h3 style="font-size: 13px;"></h3>
         <h3 style="background-color: #0585E8; padding: 20px; color: #fff; text-align: center;">Purchase Order</h3>
         <div class="pack" style="box-sizing: border-box; padding: 0px 15px;">
            <div class="pack-img" style="box-sizing: border-box; float: left;"></div>
            <div class="pack-details" style="box-sizing: border-box; padding-left: 20px; float: left; width: 100%;">
               <h3 style="font-size: 13px;">Hello,</h3>
               <h1>{{ $username }}</h1>
                <h5>Purchase order Number : {{ $purchase_order }}</h5>
                <h5>Purchase order Date : {{ $purchase_order_date }}</h5>
               
               <h5>please saw attched PDF file for the complete detail</h5>
               <h4>Regards,</h4>
               <h4 style="margin: 10px 0px 0px;">{{ config('constants.site_title') }}.</h4>
            </div>
         </div>
         <div class="clearfix" style="box-sizing: border-box; clear: both;"></div>
         <div class="text-center" style="box-sizing: border-box; text-align: center;">
         </div>
      </div>
   </body>
</html>