$(document).ready(function () {

    $('#login_form').validate({
        rules: {
            staff_email: {
                required: true,
                email: true
            },
            staff_password: {
                required: true,                
            }
        },
        messages :{
            staff_email : {
                required : '<small style="color:red">Please Enter Email Address</small>',
                email : '<small style="color:red">Please Enter Valid Email Address</small>'
            },
            staff_password : {
                required : '<small style="color:red">Please Enter Password</small>'
            }
        }
    });

    $('#forgot_form').validate({
        rules: {
            staff_email: {
                required: true,
                email: true
            }
        },
        messages :{
            staff_email : {
                required : '<small style="color:red">Please Enter Email Address</small>',
                email : '<small style="color:red">Please Enter Valid Email Address</small>'
            }
        }
    });

    $('#staff_form').validate({ 
        rules: {
            staff_fname: {
                required: true
            },
            staff_lname: {
                required: true
            },
            staff_dob: {
                required: true
            },
            staff_email: {
                required: true,
                email: true
            },
            staff_mobile: {
                required: true
            },
            staff_haddress: {
                required: true
            },
            staff_hsuburb: {
                required: true
            },
            staff_hstate: {
                required: true
            },
            staff_hpost_code: {
                required: true
            },
            staff_ename: {
                required: true
            },
            staff_erelationship: {
                required: true
            },
            staff_ephone: {
                required: true
            },
            staff_residence: {
                required: true
            },
            staff_nationality: {
                required: true
            }
        },
        messages :{
            staff_fname : {  
                required : '<small style="color:red">Please Enter First Name</small>'
            },
            staff_lname : {  
                required : '<small style="color:red">Please Enter Last Name</small>'
            },
            staff_dob : {  
                required : '<small style="color:red">Please Select DOB</small>'
            },
            staff_email : {  
                required : '<small style="color:red">Please Enter Email Address</small>',
                email : '<small style="color:red">Please Enter Valid Email Address</small>'
            },
            staff_mobile : {
                required : '<small style="color:red">Please Enter Mobile</small>'
            },
            staff_haddress : {
                required : '<small style="color:red">Please Enter Home Address</small>'
            },
            staff_hsuburb : {
                required : '<small style="color:red">Please Enter Suburb</small>'
            },
            staff_hstate : {
                required : '<small style="color:red">Please Enter State</small>'
            },
            staff_hpost_code : {
                required : '<small style="color:red">Please Enter Post Code</small>'
            },
            staff_ename : {
                required : '<small style="color:red">Please Enter Name</small>'
            },
            staff_erelationship : {
                required : '<small style="color:red">Please Enter Relationship</small>'
            },
            staff_ephone : {
                required : '<small style="color:red">Please Enter Phone</small>'
            },
            staff_residence : {
                required : '<small style="color:red">Please Select Residence status</small>'
            },
            staff_nationality : {
                required : '<small style="color:red">Please Enter Nationality</small>'
            }
        }
    });

    $('#staff_qualification_form').validate({ 
        rules: {
            staff_certification_body: {
                required: true
            },
            staff_certification_held: {
                required: true
            },
            staff_level_qualification: {
                required: true
            }
        },
        messages :{
            staff_certification_body : {  
                required : '<small style="color:red">Please Enter Certification Body</small>'
            },
            staff_certification_held : {  
                required : '<small style="color:red">Please Enter Certification Held</small>'
            },
            staff_level_qualification : {
                required : '<small style="color:red">Please Enter Level of Qualification</small>'
            }
        }
    });

    $('#staff_induction_form').validate({ 
        rules: {
            staff_induction_client: {
                required: true
            },
            staff_induction_site: {
                required: true
            },
            staff_induction_name: {
                required: true
            },
            staff_induction_type: {
                required: true
            }
        },
        messages :{
            staff_induction_client : {  
                required : '<small style="color:red">Please Select Client</small>'
            },
            staff_induction_site : {  
                required : '<small style="color:red">Please Enter Inducted Site</small>'
            },
            staff_induction_name : {
                required : '<small style="color:red">Please Enter Name</small>'
            },
            staff_induction_type : {
                required : '<small style="color:red">Please Select Type</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "staff_induction_client") 
          {
            error.appendTo($("#staff_induction_client_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#staff_licence_form').validate({ 
        rules: {
            staff_training: {
                required: true
            },
            staff_texpiry: {
                required: true
            },
            staff_training_type: {
                required: true
            }
        },
        messages :{
            staff_training : {  
                required : '<small style="color:red">Please Select Training</small>'
            },
            staff_texpiry : {  
                required : '<small style="color:red">Please Select Expiry Date</small>'
            },
            staff_training_type : {
                required : '<small style="color:red">Please Select Training Type</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "staff_training") 
          {
            error.appendTo($("#staff_training_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#staff_identification_form').validate({ 
        rules: {
            staff_id_country: {
                required: true
            },
            staff_id_type: {
                required: true
            }
        },
        messages :{
            staff_id_country : {  
                required : '<small style="color:red">Please Enter County of Issue</small>'
            },
            staff_id_type : {  
                required : '<small style="color:red">Please Select Type</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "staff_id_type") 
          {
            error.appendTo($("#staff_id_type_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });
    
    $('#password_form').validate({ 
        rules: {
            old_password: {
                required: true,
                remote:{
                  type:'post',
                  url: '/staff/check_old_password',
                  data:{
                    old_password : function(){
                      return $("#old_password").val();
                    },
                    _token: $("input[name='_token']").val()
                  }
                }
            },
            new_password: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        messages :{
            old_password : {
                required : '<small style="color:red">Please Enter Old Password</small>',
                remote : '<small style="color:red">Old Password Does Not Match</small>',
            },
            new_password : {
                required : '<small style="color:red">Please Enter New Password</small>'
            },
            confirm_password : {
                required : '<small style="color:red">Please Enter Confirm Password</small>',
                equalTo : '<small style="color:red">New password and confirm password does not match.</small>'
            }
        }
    });

    $('#voucher_form').validate({ 
        rules: {
            booking_description: {
                required: true
            },
            booking_nata: {
                required: true
            },
            booking_cname: {
                required: true
            },
            booking_cemail: {
                required: true
            },
            booking_cphone: {
                required: true
            },
            booking_nvehicles: {
                required: true
            },
            booking_rhours: {
                required: true
            },
            booking_aexpenses: {
                required: true
            }
        },
        messages :{
            booking_description : {  
                required : '<small style="color:red">Please Enter Description</small>'
            },
            booking_nata : {  
                required : '<small style="color:red">Please Enter Number of NATA Report</small>'
            },
            booking_cname : {
                required : '<small style="color:red">Please Enter Name</small>'
            },
            booking_cemail : {
                required : '<small style="color:red">Please Enter Email</small>'
            },
            booking_cphone : {
                required : '<small style="color:red">Please Enter Phone</small>'
            },
            booking_nvehicles : {
                required : '<small style="color:red">Please Enter Number of Vehicles</small>'
            },
            booking_rhours : {
                required : '<small style="color:red">Please Enter Reporting Hours</small>'
            },
            booking_aexpenses : {
                required : '<small style="color:red">Please Enter Additional Expenses</small>'
            }
        }
    });

    $('#working_hour_form').validate({ 
        rules: {
            wh_date: {
                required: true
            },
            wh_technician: {
                required: true
            },
            wh_left_base: {
                required: true
            },
            wh_return_base: {
                required: true
            },
            wh_start_time: {
                required: true
            },
            wh_finish_time: {
                required: true
            }
        },
        messages :{
            wh_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            wh_technician : {  
                required : '<small style="color:red">Please Select Technician</small>'
            },
            wh_left_base : {
                required : '<small style="color:red">Please Select Left Base</small>'
            },
            wh_return_base : {
                required : '<small style="color:red">Please Select Return Base</small>'
            },
            wh_start_time : {
                required : '<small style="color:red">Please Select Start Time</small>'
            },
            wh_finish_time : {
                required : '<small style="color:red">Please Select Finish Time</small>'
            }
        }
    });

    $('#leave_form').validate({ 
        rules: {
            leave_type: {
                required: true
            },
            leave_date: {
                required: true
            },
            leave_sdate: {
                required: true
            },
            leave_wdate: {
                required: true
            },
            leave_reason: {
                required: true
            },
            'leave_request[]': {
                required: true
            }
        },
        messages :{
            leave_type : {  
                required : '<small style="color:red">Please Select Type</small>'
            },
            leave_date : {  
                required : '<small style="color:red">Please Select Apply Date</small>'
            },
            leave_sdate : {
                required : '<small style="color:red">Please Select Leave Start Date</small>'
            },
            leave_wdate : {
                required : '<small style="color:red">Please Select Returning to Work</small>'
            },
            leave_reason : {
                required : '<small style="color:red">Please Enter Reason</small>'
            },
            'leave_request[]' : {
                required : '<small style="color:red">Please Select Leave Requested to</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "leave_type") 
          {
            error.appendTo($("#leave_type_error"));
          }
          else if(element.attr("name") == "leave_request[]") 
          {
            error.appendTo($("#leave_request_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#attendance_form').validate({ 
        rules: {
            attendance_date: {
                required: true
            },
            attendance_type: {
                required: true
            }
        },
        messages :{
            attendance_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            attendance_type : {  
                required : '<small style="color:red">Please Select Attendance</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "attendance_type") 
          {
            error.appendTo($("#attendance_type_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#timesheet_form').validate({ 
        rules: {
            timesheet_date: {
                required: true
            },
            timesheet_wtype: {
                required: true
            }
        },
        messages :{
            timesheet_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            timesheet_wtype : {  
                required : '<small style="color:red">Please Select Status</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "timesheet_wtype") 
          {
            error.appendTo($("#timesheet_wtype_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#trip_log_form').validate({ 
        rules: {
            trip_log_date: {
                required: true
            },
            trip_log_driver: {
                required: true
            },
            trip_log_stime: {
                required: true
            },
            trip_log_sodometer: {
                required: true
            }
        },
        messages :{
            trip_log_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            trip_log_driver : {  
                required : '<small style="color:red">Please Enter Driver</small>'
            },
            trip_log_stime : {  
                required : '<small style="color:red">Please Select Start Time</small>'
            },
            trip_log_sodometer : {  
                required : '<small style="color:red">Please Enter Start Odometer</small>'
            }
        }
    });

    $('#fuel_log_form').validate({ 
        rules: {
            fuel_log_date: {
                required: true
            },
            fuel_log_driver: {
                required: true
            },
            fuel_log_odometer: {
                required: true
            },
            fuel_log_fadded: {
                required: true
            },
            fuel_log_cost: {
                required: true
            }
        },
        messages :{
            fuel_log_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            fuel_log_driver : {  
                required : '<small style="color:red">Please Enter Driver</small>'
            },
            fuel_log_odometer : {  
                required : '<small style="color:red">Please Enter Odometer Reading</small>'
            },
            fuel_log_fadded : {  
                required : '<small style="color:red">Please Enter Fuel Added</small>'
            },
            fuel_log_cost : {  
                required : '<small style="color:red">Please Enter Cost</small>'
            }
        }
    });

    $('#insurance_form').validate({ 
        rules: {
            insurance_policy_no: {
                required: true
            },
            insurance_expiry: {
                required: true
            },
            insurance_provider: {
                required: true
            },
            insurance_coverage: {
                required: true
            }
        },
        messages :{
            insurance_policy_no : {  
                required : '<small style="color:red">Please Enter Policy Number</small>'
            },
            insurance_expiry : {  
                required : '<small style="color:red">Please Select Expiry Date</small>'
            },
            insurance_provider : {  
                required : '<small style="color:red">Please Enter Provider</small>'
            },
            insurance_coverage : {  
                required : '<small style="color:red">Please Select Coverage</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "insurance_coverage") 
          {
            error.appendTo($("#insurance_coverage_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#service_log_form').validate({ 
        rules: {
            service_log_date: {
                required: true
            },
            service_log_requested: {
                required: true
            },
            service_log_odometer: {
                required: true
            },
            service_log_nodometer: {
                required: true
            },
            service_log_provider: {
                required: true
            },
            service_log_cost: {
                required: true
            }
        },
        messages :{
            service_log_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            service_log_requested : {  
                required : '<small style="color:red">Please Select Requested By</small>'
            },
            service_log_odometer : {  
                required : '<small style="color:red">Please Enter Odometer Reading</small>'
            },
            service_log_nodometer : {  
                required : '<small style="color:red">Please Enter Next Service Odometer</small>'
            },
            service_log_provider : {  
                required : '<small style="color:red">Please Enter Service Provider</small>'
            },
            service_log_cost : {  
                required : '<small style="color:red">Please Enter Cost</small>'
            }
        }
    });

    $('#cleaning_log_form').validate({ 
        rules: {
            cleaning_log_date: {
                required: true
            },
            cleaning_log_driver: {
                required: true
            },
            cleaning_log_type: {
                required: true
            },
            cleaning_log_location: {
                required: true
            },
            cleaning_log_provider: {
                required: true
            },
            cleaning_log_cost: {
                required: true
            }
        },
        messages :{
            cleaning_log_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            cleaning_log_driver : {  
                required : '<small style="color:red">Please Enter Driver</small>'
            },
            cleaning_log_type : {  
                required : '<small style="color:red">Please Enter Cleaning Type</small>'
            },
            cleaning_log_location : {  
                required : '<small style="color:red">Please Enter Location</small>'
            },
            cleaning_log_provider : {  
                required : '<small style="color:red">Please Enter Service Provider</small>'
            },
            cleaning_log_cost : {  
                required : '<small style="color:red">Please Enter Cost</small>'
            }
        }
    });

    $('#repair_log_form').validate({ 
        rules: {
            repair_log_date: {
                required: true
            },
            repair_log_odometer: {
                required: true
            },
            repair_log_performed: {
                required: true
            },
            repair_log_replaced: {
                required: true
            },
            repair_log_lcost: {
                required: true
            },
            repair_log_pcost: {
                required: true
            },
            repair_log_cost: {
                required: true
            },
            repair_log_provider: {
                required: true
            }
        },
        messages :{
            repair_log_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            repair_log_odometer : {  
                required : '<small style="color:red">Please Enter Odometer Reading</small>'
            },
            repair_log_performed : {  
                required : '<small style="color:red">Please Select Repair requested by</small>'
            },
            repair_log_replaced : {  
                required : '<small style="color:red">Please Enter Parts Replaced</small>'
            },
            repair_log_lcost : {  
                required : '<small style="color:red">Please Enter Labor Cost</small>'
            },
            repair_log_pcost : {  
                required : '<small style="color:red">Please Enter Parts Cost</small>'
            },
            repair_log_cost : {  
                required : '<small style="color:red">Please Enter Total Cost</small>'
            },
            repair_log_provider : {  
                required : '<small style="color:red">Please Enter Provider</small>'
            }
        }
    });

    $('#accident_form').validate({ 
        rules: {
            accident_date: {
                required: true
            },
            accident_time: {
                required: true
            },
            accident_driver: {
                required: true
            },
            accident_location: {
                required: true
            },
            accident_parties: {
                required: true
            },
            accident_desc: {
                required: true
            },
            accident_damage: {
                required: true
            }
        },
        messages :{
            accident_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            accident_time : {  
                required : '<small style="color:red">Please Select Time</small>'
            },
            accident_driver : {  
                required : '<small style="color:red">Please Enter Driver</small>'
            },
            accident_location : {  
                required : '<small style="color:red">Please Enter Location</small>'
            },
            accident_parties : {  
                required : '<small style="color:red">Please Enter Involved Parties</small>'
            },
            accident_desc : {  
                required : '<small style="color:red">Please Enter Description</small>'
            },
            accident_damage : {  
                required : '<small style="color:red">Please Enter Damage Details</small>'
            }
        }
    });

    $('#inspection_form').validate({ 
        rules: {
            inspection_date: {
                required: true
            },
            inspection_odometer: {
                required: true
            },
            inspection_inspected: {
                required: true
            }
        },
        messages :{
            inspection_date : {  
                required : '<small style="color:red">Please Select Date</small>'
            },
            inspection_odometer : {  
                required : '<small style="color:red">Please Enter Odometer Reading</small>'
            },
            inspection_inspected : {  
                required : '<small style="color:red">Please Enter Inspected By</small>'
            }
        }
    });
    
});