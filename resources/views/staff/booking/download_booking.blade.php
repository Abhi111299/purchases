<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Voucher Details</title>
<style>
h4 {
    margin: 0;
}
.w-full {
    width: 100%;
}
.w-half {
    width: 50%;
}
.w-quater {
    width: 25%;
}
.w-quater1 {
    width: 33.33333333333333%;
}
.w-quater2 {
    width: 25%;
}
.margin-top {
    margin-top: 0.5rem;
}
.footer {
    font-size: 0.875rem;
    padding: 1rem;
    background-color: #f1f5f9;
}
table {
    width: 100%;
    border-spacing: 0;
    border: 1px solid #cba6a6;
}
table tr{
    border: 1px solid #cba6a6;
}
table tr td{
    border: 1px solid #cba6a6;
}
table.products {
    font-size: 0.875rem;
}
table.products tr {
    background-color: #c4c8cd;
}
table.products th {
    color: black;
    padding: 0.5rem;
}
table tr.items {
    background-color: #f1f5f9;
}
table tr.items td {
    padding: 0.5rem;
}
.total {
    text-align: right;
    margin-top: 1rem;
    font-size: 0.875rem;
}
</style>
</head>
<body>    
    <div class="margin-top">
        <table class="w-full" style="border: none">
            <tr style="border: none">
                <td style="padding: 0.5rem;border: none;width:25%">
                    <div><h4><img src="{{ asset(config('constants.admin_path').'dist/img/arl.png') }}" style="height: 120px" alt=""></h4></div>
                </td>
                <td style="padding: 0.5rem;border: none;text-align:center;width:50%">
                    <div><h2>ARL Laboratory Services Pty Ltd<br><span style="margin-top:10px;font-size: 14px">ABN - 60 075 523 689</span></h2></div>
                    <div style="margin-top: 20px;"><h4><b>Work Voucher Sheet</b></h4></div>
                </td>
                <td style="padding: 0.5rem;border: none;text-align:right;width:25%">
                    <div><h4 style="color: red">Head Office - Sydney</h4></div>
                    <div><h4 style="color: blue">Unit 13 & 14, 55-61</h4></div>
                    <div><h4 style="color: blue">Pine Road</h4></div>
                    <div><h4 style="color: blue">Yennora NSW 2161</h4></div>
                    <div><h4 style="color: blue">Email : sales@arllabservices.com.au</h4></div>
                </td>
            </tr>
        </table>
    </div>
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;">
                    <div><h4>Work Requested</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div style="text-align: right">Admin</div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div><h4>Date</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-left: #f5f5ef;">
                    <div style="text-align: right">{{ date('d M Y') }}</div>
                </td>
            </tr>
            <tr>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;">
                    <div><h4>Client</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div style="text-align: right">{{ $booking->customer_name }}</div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div><h4>Order No</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-left: #f5f5ef;">
                    <div style="text-align: right">{{ $booking->booking_order_no }}</div>
                </td>
            </tr>
            <tr>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;">
                    <div><h4>Client Contact</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div style="text-align: right">{{ $booking->customer_phone }}</div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div><h4>Client Request No</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-left: #f5f5ef;">
                    <div style="text-align: right">{{ $booking->booking_crequest_no }}</div>
                </td>
            </tr>
            <tr>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;">
                    <div><h4>Location</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div style="text-align: right">{{ $booking->booking_lname }}</div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div><h4>Client Job No</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-left: #f5f5ef;">
                    <div style="text-align: right">{{ $booking->booking_cjob_no }}</div>
                </td>
            </tr>
            <tr>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;">
                    <div><h4>Work Status</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div style="text-align: right">
                    @if($booking->booking_status == 1)
                    Pending
                    @elseif($booking->booking_status == 2)
                    Cancelled
                    @elseif($booking->booking_status == 3)
                    Incomplete
                    @elseif($booking->booking_status == 4)
                    Report Pending
                    @elseif($booking->booking_status == 5)
                    Completed
                    @elseif($booking->booking_status == 6)
                    Rescheduled
                    @elseif($booking->booking_status == 7)
                    Client Postponded
                    @elseif($booking->booking_status == 8)
                    Invoiced
                    @endif
                    </div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-right: #f5f5ef;border-left: #f5f5ef;">
                    <div><h4>Job Card No</h4></div>
                </td>
                <td class="w-quater2" style="padding: 3px;border-left: #f5f5ef;">
                    <div style="text-align: right">{{ $booking->booking_job_id }}</div>
                </td>
            </tr>
        </table>
    </div>
    <div class="margin-top">
        <table class="products" style="margin-top: 10px">
            <tr>
                <th style="text-align: center;padding: 3px;">Job Description</th>
            </tr>
            <tr class="items">
                <td style="text-align: left;padding: 3px;">{{ $booking->booking_description }}</td>
            </tr>
        </table>
    </div>
    <div class="margin-top">
        <table class="products">
            <tr>
                <th style="text-align: center;width:75%;padding: 3px;">Equipment</th>
                <th style="text-align: center;width:25%;padding: 3px;">Quantity</th>
            </tr>
            @if(!empty($booking->booking_equipments))
            @php $booking_equipments = json_decode($booking->booking_equipments,true) @endphp
            @foreach($booking_equipments['EQUIPMENT'] as $key => $booking_equipment)
            <tr class="items">
                @if(isset($equipments[$booking_equipments['EQUIPMENT'][$key]]))
                <td style="text-align: center;padding: 3px;">{{ $equipments[$booking_equipments['EQUIPMENT'][$key]] }}</td>
                @else
                <td style="text-align: center;padding: 3px;">-</td>
                @endif
                <td style="text-align: center;padding: 3px;">{{ $booking_equipments['QTY'][$key] }}</td>
            </tr>
            @endforeach
            @endif
        </table>
    </div>
    <div class="margin-top">
        <table class="products">
            <tr>
                <th style="text-align: center;width:75%;padding: 3px;">Consumable</th>
                <th style="text-align: center;width:25%;padding: 3px;">Quantity</th>
            </tr>
            @if(!empty($booking->booking_consumables))
            @php $booking_consumables = json_decode($booking->booking_consumables,true) @endphp
            @foreach($booking_consumables['CONSUMABLE'] as $key => $booking_consumable)
            <tr class="items">
                @if(isset($consumables[$booking_consumables['CONSUMABLE'][$key]]))
                <td style="text-align: center;padding: 3px;">{{ $consumables[$booking_consumables['CONSUMABLE'][$key]] }}</td>
                @else
                <td style="text-align: center;padding: 3px;">-</td>
                @endif
                <td style="text-align: center;padding: 3px;">{{ $booking_consumables['QTY'][$key] }}</td>
            </tr>
            @endforeach
            @endif
        </table>
    </div>
    <div class="margin-top">
        <table class="products">
            <tr>
                <th style="text-align: center;width:25%;padding: 3px;">Number of NATA Report</th>
                <th style="text-align: center;width:25%;padding: 3px;">Number of Vehicles</th>
                <th style="text-align: center;width:25%;padding: 3px;">Additional Expenses</th>
                <th style="text-align: center;width:25%;padding: 3px;">Reporting Hours</th>
            </tr>
            <tr class="items">
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_nata }}</td>
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_nvehicles }}</td>
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_aexpenses }}</td>
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_rhours }}</td>
            </tr>
        </table>
    </div>
    <div class="margin-top">
        <table class="products">
            <tr>
                <th style="text-align: center;padding: 3px;">S.No</th>
                <th style="text-align: center;padding: 3px;">Date</th>
                <th style="text-align: center;padding: 3px;">Inspector / Technician</th>
                <th style="text-align: center;padding: 3px;">Left Base</th>
                <th style="text-align: center;padding: 3px;">Start Time</th>
                <th style="text-align: center;padding: 3px;">Finish Time</th>
                <th style="text-align: center;padding: 3px;">Return Base</th>
            </tr>
            @foreach($working_hours as $working_hour)
            <tr class="items">
                <td style="text-align: center;padding: 3px;">{{ $loop->iteration }}</td>
                <td style="text-align: center;padding: 3px;">{{ date('d M Y',strtotime($working_hour->wh_date)) }}</td>
                <td style="text-align: center;padding: 3px;">{{ $working_hour->staff_fname.' '.$working_hour->staff_lname }}</td>
                <td style="text-align: center;padding: 3px;">{{ date('h:i A',strtotime($working_hour->wh_left_base)) }}</td>
                <td style="text-align: center;padding: 3px;">{{ date('h:i A',strtotime($working_hour->wh_start_time)) }}</td>
                <td style="text-align: center;padding: 3px;">{{ date('h:i A',strtotime($working_hour->wh_finish_time)) }}</td>
                <td style="text-align: center;padding: 3px;">{{ date('h:i A',strtotime($working_hour->wh_return_base)) }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="margin-top">
        <table class="products">
            <tr>
                <th style="text-align: center;width:25%;padding: 3px;">ARL Representative</th>
                <th style="text-align: center;width:25%;padding: 3px;">Signature</th>
                <th style="text-align: center;width:25%;padding: 3px;">Phone</th>
                <th style="text-align: center;width:25%;padding: 3px;">Email ID</th>   
            </tr>
            <tr class="items">
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_vname }}</td>
                <td style="text-align: center;padding: 3px;">
                @if(!empty($booking->booking_vsignature))
                <img src="{{ asset(config('constants.admin_path').'uploads/signature/'.$booking->booking_vsignature) }}" style="height: 50px;" alt="">
                @else
                -
                @endif
                </td>
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_vphone }}</td>
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_vemail }}</td>
            </tr>
        </table>
    </div>
    <div class="margin-top">
        <table class="products">
            <tr>
                <th style="text-align: center;width:25%;padding: 3px;">Client Representative</th>
                <th style="text-align: center;width:25%;padding: 3px;">Signature</th>
                <th style="text-align: center;width:25%;padding: 3px;">Phone</th>
                <th style="text-align: center;width:25%;padding: 3px;">Email ID</th>
            </tr>
            <tr class="items">
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_cname }}</td>
                <td style="text-align: center;padding: 3px;">
                @if(!empty($booking->booking_csignature))
                <img src="{{ asset(config('constants.admin_path').'uploads/signature/'.$booking->booking_csignature) }}" style="height: 50px;" alt="">
                @else
                -
                @endif
                </td>
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_cphone }}</td>
                <td style="text-align: center;padding: 3px;">{{ $booking->booking_cemail }}</td>
            </tr>
        </table>
    </div>
    <div class="footer margin-top">
        <div>Thank you <span>&copy; {{ config('constants.site_title') }}</span></div>
    </div>
</body>
</html>