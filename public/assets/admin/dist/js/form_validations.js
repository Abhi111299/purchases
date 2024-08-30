$(document).ready(function () {

    $('#login_form').validate({
        rules: {
            admin_email: {
                required: true,
                email: true
            },
            admin_password: {
                required: true,                
            }
        },
        messages :{
            admin_email : {
                required : '<small style="color:red">Please Enter Email Address</small>',
                email : '<small style="color:red">Please Enter Valid Email Address</small>'
            },
            admin_password : {
                required : '<small style="color:red">Please Enter Password</small>'
            }
        }
    });

    $('#forgot_form').validate({
        rules: {
            admin_email: {
                required: true,
                email: true
            }
        },
        messages :{
            admin_email : {
                required : '<small style="color:red">Please Enter Email Address</small>',
                email : '<small style="color:red">Please Enter Valid Email Address</small>'
            }
        }
    });

    $('#profile_form').validate({ 
        rules: {
            admin_name: {
                required: true
            },
            admin_email: {
                required: true,
                email: true
            },
            admin_phone: {
                required: true
            }
        },
        messages :{
            admin_name : {  
                required : '<small style="color:red">Please Enter Name</small>'
            },
            admin_email : {  
                required : '<small style="color:red">Please Enter Email Address</small>',
                email : '<small style="color:red">Please Enter Valid Email Address</small>'
            },
            admin_phone : {
                required : '<small style="color:red">Please Enter Phone</small>'
            }
        }
    });

    $('#password_form').validate({ 
        rules: {
            old_password: {
                required: true,
                remote:{
                  type:'post',
                  url: '/admin/check_old_password',
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
    
    $('#customer_form').validate({ 
        rules: {
            customer_name: {
                required: true
            }
        },
        messages :{
            customer_name : {  
                required : '<small style="color:red">Please Enter Name</small>'
            }
        }
    });

    $('#staff_form').validate({ 
        rules: {
            staff_no: {
                required: true
            },
            staff_dept: {
                required: true
            },
            staff_role: {
                required: true
            },
            staff_job_type: {
                required: true
            },
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
            staff_password: {
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
            staff_no : {  
                required : '<small style="color:red">Please Enter Employee No</small>'
            },
            staff_dept : {  
                required : '<small style="color:red">Please Select Department</small>'
            },
            staff_role : {  
                required : '<small style="color:red">Please Select Job Title</small>'
            },
            staff_job_type : {  
                required : '<small style="color:red">Please Select Job Status</small>'
            },
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
            staff_password : {
                required : '<small style="color:red">Please Enter Password</small>'
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

    $('#service_form').validate({ 
        rules: {
            service_name: {
                required: true
            },
            service_desc: {
                required: true
            }
        },
        messages :{
            service_name : {  
                required : '<small style="color:red">Please Enter Service</small>'
            },
            service_desc : {  
                required : '<small style="color:red">Please Enter Description</small>'
            }
        }
    });

    $('#activity_form').validate({ 
        rules: {
            activity_name: {
                required: true
            },
            activity_code: {
                required: true
            }
        },
        messages :{
            activity_name : {  
                required : '<small style="color:red">Please Enter Activity</small>'
            },
            activity_code : {  
                required : '<small style="color:red">Please Enter Code</small>'
            }
        }
    });

    $('#booking_form').validate({ 
        rules: {
            booking_service: {
                required: true
            },
            booking_customer: {
                required: true
            },
            booking_start: {
                required: true
            },
            booking_end: {
                required: true
            },
            'booking_activities[]': {
                required: true
            },
            'booking_staffs[]': {
                required: true
            },
            booking_branch: {
                required: true
            }
        },
        messages :{
            booking_service : {  
                required : '<small style="color:red">Please Select Service</small>'
            },
            booking_customer : {  
                required : '<small style="color:red">Please Select Client</small>'
            },
            booking_start : {
                required : '<small style="color:red">Please Select Start Date</small>'
            },
            booking_end : {
                required : '<small style="color:red">Please Select End Date</small>'
            },
            'booking_activities[]' : {
                required : '<small style="color:red">Please Select Activities</small>'
            },
            'booking_staffs[]' : {
                required : '<small style="color:red">Please Select Technicians</small>'
            },
            booking_branch : {
                required : '<small style="color:red">Please Select Location</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "booking_service") 
          {
            error.appendTo($("#booking_service_error"));
          }
          else if(element.attr("name") == "booking_customer") 
          {
            error.appendTo($("#booking_customer_error"));
          } 
          else if(element.attr("name") == "booking_activities[]") 
          {
            error.appendTo($("#booking_activities_error"));
          } 
          else if(element.attr("name") == "booking_staffs[]") 
          {
            error.appendTo($("#booking_staffs_error"));
          } 
          else if(element.attr("name") == "booking_branch") 
          {
            error.appendTo($("#booking_branch_error"));
          } 
          else 
          {
            error.insertAfter(element);
          }
        },
        submitHandler: function (form) {
            swal("Please Wait.Loading...");
            form.submit();
        }
    });

    $('#edit_booking_form').validate({ 
        rules: {
            booking_service: {
                required: true
            },
            booking_customer: {
                required: true
            },
            booking_start: {
                required: true
            },
            booking_end: {
                required: true
            },
            'booking_activities[]' : {
                required : '<small style="color:red">Please Select Activities</small>'
            },
            'booking_staffs[]': {
                required: true
            },
            booking_branch: {
                required: true
            }
        },
        messages :{
            booking_service : {  
                required : '<small style="color:red">Please Select Service</small>'
            },
            booking_customer : {  
                required : '<small style="color:red">Please Select Client</small>'
            },
            booking_start : {
                required : '<small style="color:red">Please Select Start Date</small>'
            },
            booking_end : {
                required : '<small style="color:red">Please Select End Date</small>'
            },
            'booking_activities[]' : {
                required : '<small style="color:red">Please Select Activities</small>'
            },
            'booking_staffs[]' : {
                required : '<small style="color:red">Please Select Technicians</small>'
            },
            booking_branch : {
                required : '<small style="color:red">Please Select Location</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "booking_service") 
          {
            error.appendTo($("#booking_service_error"));
          }
          else if(element.attr("name") == "booking_customer") 
          {
            error.appendTo($("#booking_customer_error"));
          }
          else if(element.attr("name") == "booking_activities[]") 
          {
            error.appendTo($("#booking_activities_error"));
          }  
          else if(element.attr("name") == "booking_staffs[]") 
          {
            error.appendTo($("#booking_staffs_error"));
          }
          else if(element.attr("name") == "booking_branch") 
          {
            error.appendTo($("#booking_branch_error"));
          }  
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#user_form').validate({ 
        rules: {
            admin_name: {
                required: true
            },
            admin_email: {
                required: true,
                email: true
            },
            admin_phone: {
                required: true
            },
            admin_password: {
                required: true
            },
            'admin_modules[]': {
                required: true
            }
        },
        messages :{
            admin_name : {  
                required : '<small style="color:red">Please Enter Name</small>'
            },
            admin_email : {  
                required : '<small style="color:red">Please Enter Email Address</small>',
                email : '<small style="color:red">Please Enter Valid Email Address</small>'
            },
            admin_phone : {
                required : '<small style="color:red">Please Enter Phone</small>'
            },
            admin_password : {
                required : '<small style="color:red">Please Enter Password</small>'
            },
            'admin_modules[]' : {
                required : '<small style="color:red">Please Select Modules</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "admin_modules[]") 
          {
            error.appendTo($("#admin_modules_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#training_form').validate({ 
        rules: {
            training_name: {
                required: true
            }
        },
        messages :{
            training_name : {  
                required : '<small style="color:red">Please Enter Training</small>'
            }
        }
    });

    $('#equipment_form').validate({ 
        rules: {
            equipment_name: {
                required: true
            }
        },
        messages :{
            equipment_name : {  
                required : '<small style="color:red">Please Enter Equipment</small>'
            }
        }
    });

    $('#consumable_form').validate({ 
        rules: {
            consumable_name: {
                required: true
            }
        },
        messages :{
            consumable_name : {  
                required : '<small style="color:red">Please Enter Equipment</small>'
            }
        }
    });

    $('#location_form').validate({ 
        rules: {
            location_name: {
                required: true
            }
        },
        messages :{
            location_name : {  
                required : '<small style="color:red">Please Enter Location</small>'
            }
        }
    });

    $('#department_form').validate({ 
        rules: {
            department_name: {
                required: true
            }
        },
        messages :{
            department_name : {  
                required : '<small style="color:red">Please Enter Department</small>'
            }
        }
    });

    $('#manufacturer_form').validate({ 
        rules: {
            manufacturer_name: {
                required: true
            }
        },
        messages :{
            manufacturer_name : {  
                required : '<small style="color:red">Please Enter Manufacturer</small>'
            }
        }
    });

    $('#model_form').validate({ 
        rules: {
            model_manufacturer: {
                required: true
            },
            model_name: {
                required: true
            }
        },
        messages :{
            model_manufacturer : {  
                required : '<small style="color:red">Please Select Manufacturer</small>'
            },
            model_name : {  
                required : '<small style="color:red">Please Enter Model</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "model_manufacturer") 
          {
            error.appendTo($("#model_manufacturer_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#vehicle_form').validate({ 
        rules: {
            vehicle_manufacturer: {
                required: true
            },
            vehicle_model: {
                required: true
            },
            vehicle_year: {
                required: true
            },
            vehicle_license_no: {
                required: true
            },
            vehicle_no: {
                required: true
            }
        },
        messages :{
            vehicle_manufacturer : {  
                required : '<small style="color:red">Please Select Manufacturer</small>'
            },
            vehicle_model : {  
                required : '<small style="color:red">Please Select Model</small>'
            },
            vehicle_year : {  
                required : '<small style="color:red">Please Select Year</small>'
            },
            vehicle_license_no : {  
                required : '<small style="color:red">Please Enter License Plate No</small>'
            },
            vehicle_no : {  
                required : '<small style="color:red">Please Enter Vehicle Identification No</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "vehicle_manufacturer") 
          {
            error.appendTo($("#vehicle_manufacturer_error"));
          }
          else if(element.attr("name") == "vehicle_model") 
          {
            error.appendTo($("#vehicle_model_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#vehicle_ownership_form').validate({ 
        rules: {
            vehicle_owner: {
                required: true
            },
            vehicle_address: {
                required: true
            },
            vehicle_reg_date: {
                required: true
            },
            vehicle_exp_date: {
                required: true
            },
            vehicle_authority: {
                required: true
            },
            vehicle_state: {
                required: true
            },
            vehicle_location: {
                required: true
            },
            vehicle_driver: {
                required: true
            }
        },
        messages :{
            vehicle_owner : {  
                required : '<small style="color:red">Please Enter Owner Name</small>'
            },
            vehicle_address : {  
                required : '<small style="color:red">Please Enter Address</small>'
            },
            vehicle_reg_date : {  
                required : '<small style="color:red">Please Select Date of Registration</small>'
            },
            vehicle_exp_date : {  
                required : '<small style="color:red">Please Select Expiry Date</small>'
            },
            vehicle_authority : {  
                required : '<small style="color:red">Please Enter Issuing Authority</small>'
            },
            vehicle_state : {  
                required : '<small style="color:red">Please Select State</small>'
            },
            vehicle_location : {  
                required : '<small style="color:red">Please Select Car Location</small>'
            },
            vehicle_driver : {  
                required : '<small style="color:red">Please Select Assigned Driver</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "vehicle_location") 
          {
            error.appendTo($("#vehicle_location_error"));
          }
          else if(element.attr("name") == "vehicle_state") 
          {
            error.appendTo($("#vehicle_state_error"));
          }
          else if(element.attr("name") == "vehicle_driver") 
          {
              error.appendTo($("#vehicle_driver_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#vehicle_specification_form').validate({ 
        rules: {
            vehicle_engine_type: {
                required: true
            },
            vehicle_transmission: {
                required: true
            },
            vehicle_fuel_type: {
                required: true
            },
            vehicle_body_type: {
                required: true
            },
            vehicle_color: {
                required: true
            },
            vehicle_odometer_reading: {
                required: true
            }
        },
        messages :{
            vehicle_engine_type : {  
                required : '<small style="color:red">Please Enter Engine Type</small>'
            },
            vehicle_transmission : {  
                required : '<small style="color:red">Please Select Transmission</small>'
            },
            vehicle_fuel_type : {  
                required : '<small style="color:red">Please Select Fuel Type</small>'
            },
            vehicle_body_type : {  
                required : '<small style="color:red">Please Select Body Type</small>'
            },
            vehicle_color : {  
                required : '<small style="color:red">Please Enter Color</small>'
            },
            vehicle_odometer_reading : {  
                required : '<small style="color:red">Please Enter Odometer Reading</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "vehicle_transmission") 
          {
            error.appendTo($("#vehicle_transmission_error"));
          }
          else if(element.attr("name") == "vehicle_fuel_type") 
          {
            error.appendTo($("#vehicle_fuel_type_error"));
          }
          else if(element.attr("name") == "vehicle_body_type") 
          {
            error.appendTo($("#vehicle_body_type_error"));
          }
          else 
          {
            error.insertAfter(element);
          }
        }
    });

    $('#vehicle_financial_form').validate({ 
        rules: {
            vehicle_type: {
                required: true
            }
        },
        messages :{
            vehicle_type : {  
                required : '<small style="color:red">Please Select Type</small>'
            }
        },
        errorPlacement: function(error, element) {

          if(element.attr("name") == "vehicle_type") 
          {
            error.appendTo($("#vehicle_type_error"));
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
    
    $('#asset_form').validate({ 
        rules: {
            asset_name: {
                required: true
            }
        },
        messages :{
            asset_name : {  
                required : '<small style="color:red">Please Enter Asset</small>'
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
    
    $('#edit_working_hour_form').validate({ 
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
    
});