<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminCalendarController;
use App\Http\Controllers\Admin\AdminTimesheetController;
use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\Admin\AdminLeaveRequestController;
use App\Http\Controllers\Admin\AdminAssetController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminTripLogController;
use App\Http\Controllers\Admin\AdminFuelLogController;
use App\Http\Controllers\Admin\AdminInsuranceController;
use App\Http\Controllers\Admin\AdminServiceLogController;
use App\Http\Controllers\Admin\AdminCleanLogController;
use App\Http\Controllers\Admin\AdminRepairLogController;
use App\Http\Controllers\Admin\AdminAccidentController;
use App\Http\Controllers\Admin\AdminInspectionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminTrainingController;
use App\Http\Controllers\Admin\AdminEquipmentController;
use App\Http\Controllers\Admin\AdminConsumableController;
use App\Http\Controllers\Admin\AdminLocationController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\Admin\AdminManufacturerController;
use App\Http\Controllers\Admin\AdminModelController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminLogoutController;
use App\Http\Controllers\Staff\JobController;
use App\Http\Controllers\Staff\StaffLoginController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\StaffBookingController;
use App\Http\Controllers\Staff\StaffAttendanceController;
use App\Http\Controllers\Staff\StaffTimesheetController;
use App\Http\Controllers\Staff\StaffLeaveController;
use App\Http\Controllers\Staff\StaffLeaveRequestController;
use App\Http\Controllers\Staff\StaffAssetController;
use App\Http\Controllers\Staff\StaffVehicleController;
use App\Http\Controllers\Staff\StaffTripLogController;
use App\Http\Controllers\Staff\StaffFuelLogController;
use App\Http\Controllers\Staff\StaffInsuranceController;
use App\Http\Controllers\Staff\StaffServiceLogController;
use App\Http\Controllers\Staff\StaffCleanLogController;
use App\Http\Controllers\Staff\StaffRepairLogController;
use App\Http\Controllers\Staff\StaffAccidentController;
use App\Http\Controllers\Staff\StaffInspectionController;
use App\Http\Controllers\Staff\StaffProfileController;
use App\Http\Controllers\Staff\StaffLogoutController;
use App\Http\Controllers\Admin\AdminPurchaseRequestController;
use App\Http\Controllers\Staff\StaffPurchaseRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/thank_you', function() {
    return view('staff.mail.thank_you'); // Path is relative to resources/views/
})->name('thank_you');

Route::middleware(['checkadminlogin'])->group(function () {

    Route::match(['get','post'],'/', [AdminLoginController::class, 'index']);
    Route::match(['get','post'],'forgot_password', [AdminLoginController::class, 'forgot_password']);

});

Route::middleware(['checkadmin'])->group(function () {

    Route::prefix('admin')->group(function () {

        //Dashboard

        Route::get('dashboard', [AdminDashboardController::class, 'index']);
        Route::post('get_today_bookings', [AdminDashboardController::class, 'get_today_bookings']);

        //Customer

        Route::get('customers', [AdminCustomerController::class, 'index']);
        Route::post('get_customers', [AdminCustomerController::class, 'get_customers']);
        Route::match(['get','post'],'add_customer', [AdminCustomerController::class, 'add_customer']);
        Route::match(['get','post'],'edit_customer/{id}', [AdminCustomerController::class, 'edit_customer']);
        Route::get('customer_status/{id}/{status}', [AdminCustomerController::class, 'customer_status']);

        //Staff

        Route::get('staffs', [AdminStaffController::class, 'index']);
        Route::post('get_staffs', [AdminStaffController::class, 'get_staffs']);
        Route::match(['get','post'],'add_staff', [AdminStaffController::class, 'add_staff']);
        Route::match(['get','post'],'edit_staff/{id}', [AdminStaffController::class, 'edit_staff']);
        Route::post('add_staff_qualification/{id}', [AdminStaffController::class, 'add_staff_qualification']);
        Route::post('add_staff_induction/{id}', [AdminStaffController::class, 'add_staff_induction']);
        Route::post('add_staff_licence/{id}', [AdminStaffController::class, 'add_staff_licence']);
        Route::post('add_staff_identification/{id}', [AdminStaffController::class, 'add_staff_identification']);
        Route::post('add_staff_document/{id}', [AdminStaffController::class, 'add_staff_document']);
        Route::get('staff_status/{id}/{status}', [AdminStaffController::class, 'staff_status']);

        Route::get('certificates', [AdminStaffController::class, 'certificates']);
        Route::post('get_certificates', [AdminStaffController::class, 'get_certificates']);
        Route::get('certificates_download_excel', [AdminStaffController::class, 'certificates_download_excel']);

        Route::get('safety_inductions', [AdminStaffController::class, 'safety_inductions']);
        Route::post('get_safety_inductions', [AdminStaffController::class, 'get_safety_inductions']);
        Route::get('safety_inductions_download_excel', [AdminStaffController::class, 'safety_inductions_download_excel']);

        Route::get('safety_licences', [AdminStaffController::class, 'safety_licences']);
        Route::post('get_safety_licences', [AdminStaffController::class, 'get_safety_licences']);
        Route::get('safety_licences_download_excel', [AdminStaffController::class, 'safety_licences_download_excel']);

        //Service

        Route::get('services', [AdminServiceController::class, 'index']);
        Route::post('get_services', [AdminServiceController::class, 'get_services']);
        Route::match(['get','post'],'add_service', [AdminServiceController::class, 'add_service']);
        Route::match(['get','post'],'edit_service/{id}', [AdminServiceController::class, 'edit_service']);
        Route::get('service_status/{id}/{status}', [AdminServiceController::class, 'service_status']);

        //Activity

        Route::get('activities', [AdminActivityController::class, 'index']);
        Route::post('get_activities', [AdminActivityController::class, 'get_activities']);
        Route::match(['get','post'],'add_activity', [AdminActivityController::class, 'add_activity']);
        Route::match(['get','post'],'edit_activity/{id}', [AdminActivityController::class, 'edit_activity']);
        Route::get('activity_status/{id}/{status}', [AdminActivityController::class, 'activity_status']);

        //Booking

        Route::get('bookings', [AdminBookingController::class, 'index']);
        Route::post('get_bookings', [AdminBookingController::class, 'get_bookings']);
        Route::match(['get','post'],'add_booking', [AdminBookingController::class, 'add_booking']);
        Route::post('select_customer', [AdminBookingController::class, 'select_customer']);
        Route::post('select_end_date', [AdminBookingController::class, 'select_end_date']);
        Route::match(['get','post'],'edit_booking/{id}', [AdminBookingController::class, 'edit_booking']);
        Route::get('view_booking/{id}', [AdminBookingController::class, 'view_booking']);
        Route::post('get_working_hour_details', [AdminBookingController::class, 'get_working_hour_details']);
        Route::get('download_booking/{id}', [AdminBookingController::class, 'download_booking']);
        Route::post('booking_status', [AdminBookingController::class, 'booking_status']);
        Route::post('add_booking_status', [AdminBookingController::class, 'add_booking_status']);
        Route::get('booking_download_excel', [AdminBookingController::class, 'booking_download_excel']);
        Route::post('update_booking_status/{id}', [AdminBookingController::class, 'update_booking_status']);
        Route::post('upload_booking_files/{id}', [AdminBookingController::class, 'upload_booking_files']);
        Route::post('update_voucher/{id}', [AdminBookingController::class, 'update_voucher']);
        Route::post('add_working_hour/{id}', [AdminBookingController::class, 'add_working_hour']);
        Route::post('edit_working_hour/{id}', [AdminBookingController::class, 'edit_working_hour']);
        Route::post('upload_photographs/{id}', [AdminBookingController::class, 'upload_photographs']);

        //Calendar

        Route::get('calendar', [AdminCalendarController::class, 'index']);
        Route::post('booking_detail', [AdminCalendarController::class, 'booking_detail']);

        //Timesheet

        Route::get('timesheets', [AdminTimesheetController::class, 'index']);
        Route::post('get_timesheets', [AdminTimesheetController::class, 'get_timesheets']);
        Route::match(['get','post'],'edit_timesheet/{id}', [AdminTimesheetController::class, 'edit_timesheet']);
        Route::get('timesheet_download_excel', [AdminTimesheetController::class, 'timesheet_download_excel']);

        //Attendance

        Route::get('attendances', [AdminAttendanceController::class, 'index']);
        Route::post('get_attendances', [AdminAttendanceController::class, 'get_attendances']);
        Route::match(['get','post'],'edit_attendance/{id}', [AdminAttendanceController::class, 'edit_attendance']);
        Route::get('attendance_download_excel', [AdminAttendanceController::class, 'attendance_download_excel']);

        //Leave Request

        Route::get('leave_requests', [AdminLeaveRequestController::class, 'index']);
        Route::post('get_leave_requests', [AdminLeaveRequestController::class, 'get_leave_requests']);
        Route::post('leave_requests_status', [AdminLeaveRequestController::class, 'leave_requests_status']);
        Route::post('add_leave_requests_status', [AdminLeaveRequestController::class, 'add_leave_requests_status']);
        Route::get('leave_request_download_excel', [AdminLeaveRequestController::class, 'leave_request_download_excel']);

        // purchase

        Route::get('purchase_request', [AdminPurchaseRequestController::class, 'index']);
        Route::match(['get','post'],'add_purchase_request', [AdminPurchaseRequestController::class, 'add_purchase_request']);
        Route::post('get_purchase_requests', [AdminPurchaseRequestController::class, 'get_purchase_request']);
        Route::match(['get','post'],'edit_purchase_request/{id}', [AdminPurchaseRequestController::class, 'edit_purchase_request']);
        Route::get('delete_purchase_request/{id}', [AdminPurchaseRequestController::class, 'destroy']);
        
        //Asset

        Route::get('assets', [AdminAssetController::class, 'index']);
        Route::post('get_assets', [AdminAssetController::class, 'get_assets']);
        Route::match(['get','post'],'add_asset', [AdminAssetController::class, 'add_asset']);
        Route::post('select_due_date', [AdminAssetController::class, 'select_due_date']);
        Route::match(['get','post'],'edit_asset/{id}', [AdminAssetController::class, 'edit_asset']);
        Route::get('view_asset/{id}', [AdminAssetController::class, 'view_asset']);
        Route::get('asset_status/{id}/{status}', [AdminAssetController::class, 'asset_status']);
        Route::get('delete_asset/{id}', [AdminAssetController::class, 'delete_asset']);

        //Vehicle

        Route::get('vehicles', [AdminVehicleController::class, 'index']);
        Route::post('get_vehicles', [AdminVehicleController::class, 'get_vehicles']);
        Route::match(['get','post'],'add_vehicle', [AdminVehicleController::class, 'add_vehicle']);
        Route::post('select_model', [AdminVehicleController::class, 'select_model']);
        Route::match(['get','post'],'edit_vehicle/{id}', [AdminVehicleController::class, 'edit_vehicle']);
        Route::post('add_vehicle_ownership/{id}', [AdminVehicleController::class, 'add_vehicle_ownership']);
        Route::post('add_vehicle_specification/{id}', [AdminVehicleController::class, 'add_vehicle_specification']);
        Route::post('add_vehicle_financial/{id}', [AdminVehicleController::class, 'add_vehicle_financial']);
        Route::post('add_vehicle_document/{id}', [AdminVehicleController::class, 'add_vehicle_document']);
        Route::get('vehicle_status/{id}/{status}', [AdminVehicleController::class, 'vehicle_status']);

        //Trip Log

        Route::get('trip_logs/{id}', [AdminTripLogController::class, 'index']);
        Route::post('get_trip_logs', [AdminTripLogController::class, 'get_trip_logs']);
        Route::match(['get','post'],'add_trip_log/{id}', [AdminTripLogController::class, 'add_trip_log']);
        Route::match(['get','post'],'edit_trip_log/{id}', [AdminTripLogController::class, 'edit_trip_log']);
        Route::get('trip_log_status/{id}/{status}', [AdminTripLogController::class, 'trip_log_status']);

        //Fuel Log

        Route::get('fuel_logs/{id}', [AdminFuelLogController::class, 'index']);
        Route::post('get_fuel_logs', [AdminFuelLogController::class, 'get_fuel_logs']);
        Route::match(['get','post'],'add_fuel_log/{id}', [AdminFuelLogController::class, 'add_fuel_log']);
        Route::match(['get','post'],'edit_fuel_log/{id}', [AdminFuelLogController::class, 'edit_fuel_log']);
        Route::get('fuel_log_status/{id}/{status}', [AdminFuelLogController::class, 'fuel_log_status']);

        //Insurance

        Route::get('insurances/{id}', [AdminInsuranceController::class, 'index']);
        Route::post('get_insurances', [AdminInsuranceController::class, 'get_insurances']);
        Route::match(['get','post'],'add_insurance/{id}', [AdminInsuranceController::class, 'add_insurance']);
        Route::match(['get','post'],'edit_insurance/{id}', [AdminInsuranceController::class, 'edit_insurance']);
        Route::get('insurance_status/{id}/{status}', [AdminInsuranceController::class, 'insurance_status']);

        //Service Log

        Route::get('service_logs/{id}', [AdminServiceLogController::class, 'index']);
        Route::post('get_service_logs', [AdminServiceLogController::class, 'get_service_logs']);
        Route::match(['get','post'],'add_service_log/{id}', [AdminServiceLogController::class, 'add_service_log']);
        Route::match(['get','post'],'edit_service_log/{id}', [AdminServiceLogController::class, 'edit_service_log']);
        Route::get('service_log_status/{id}/{status}', [AdminServiceLogController::class, 'service_log_status']);

        //Clean Log

        Route::get('cleaning_logs/{id}', [AdminCleanLogController::class, 'index']);
        Route::post('get_cleaning_logs', [AdminCleanLogController::class, 'get_cleaning_logs']);
        Route::match(['get','post'],'add_cleaning_log/{id}', [AdminCleanLogController::class, 'add_cleaning_log']);
        Route::match(['get','post'],'edit_cleaning_log/{id}', [AdminCleanLogController::class, 'edit_cleaning_log']);
        Route::get('cleaning_log_status/{id}/{status}', [AdminCleanLogController::class, 'cleaning_log_status']);

        //Repair Log

        Route::get('repair_logs/{id}', [AdminRepairLogController::class, 'index']);
        Route::post('get_repair_logs', [AdminRepairLogController::class, 'get_repair_logs']);
        Route::match(['get','post'],'add_repair_log/{id}', [AdminRepairLogController::class, 'add_repair_log']);
        Route::match(['get','post'],'edit_repair_log/{id}', [AdminRepairLogController::class, 'edit_repair_log']);
        Route::get('repair_log_status/{id}/{status}', [AdminRepairLogController::class, 'repair_log_status']);

        //Accident

        Route::get('accidents/{id}', [AdminAccidentController::class, 'index']);
        Route::post('get_accidents', [AdminAccidentController::class, 'get_accidents']);
        Route::match(['get','post'],'add_accident/{id}', [AdminAccidentController::class, 'add_accident']);
        Route::match(['get','post'],'edit_accident/{id}', [AdminAccidentController::class, 'edit_accident']);
        Route::get('accident_status/{id}/{status}', [AdminAccidentController::class, 'accident_status']);

        //Inspection

        Route::get('inspections/{id}', [AdminInspectionController::class, 'index']);
        Route::post('get_inspections', [AdminInspectionController::class, 'get_inspections']);
        Route::match(['get','post'],'add_inspection/{id}', [AdminInspectionController::class, 'add_inspection']);
        Route::match(['get','post'],'edit_inspection/{id}', [AdminInspectionController::class, 'edit_inspection']);
        Route::post('add_exterior_inspection/{id}', [AdminInspectionController::class, 'add_exterior_inspection']);
        Route::post('add_interior_inspection/{id}', [AdminInspectionController::class, 'add_interior_inspection']);
        Route::post('add_hood_inspection/{id}', [AdminInspectionController::class, 'add_hood_inspection']);
        Route::post('add_uvehicle_inspection/{id}', [AdminInspectionController::class, 'add_uvehicle_inspection']);
        Route::post('add_test_inspection/{id}', [AdminInspectionController::class, 'add_test_inspection']);
        Route::get('inspection_status/{id}/{status}', [AdminInspectionController::class, 'inspection_status']);

        //User

        Route::get('users', [AdminUserController::class, 'index']);
        Route::post('get_users', [AdminUserController::class, 'get_users']);
        Route::match(['get','post'],'add_user', [AdminUserController::class, 'add_user']);
        Route::match(['get','post'],'edit_user/{id}', [AdminUserController::class, 'edit_user']);
        Route::get('user_status/{id}/{status}', [AdminUserController::class, 'user_status']);

        //Training

        Route::get('trainings', [AdminTrainingController::class, 'index']);
        Route::post('get_trainings', [AdminTrainingController::class, 'get_trainings']);
        Route::match(['get','post'],'add_training', [AdminTrainingController::class, 'add_training']);
        Route::match(['get','post'],'edit_training/{id}', [AdminTrainingController::class, 'edit_training']);
        Route::get('training_status/{id}/{status}', [AdminTrainingController::class, 'training_status']);

        //Equipment

        Route::get('equipments', [AdminEquipmentController::class, 'index']);
        Route::post('get_equipments', [AdminEquipmentController::class, 'get_equipments']);
        Route::match(['get','post'],'add_equipment', [AdminEquipmentController::class, 'add_equipment']);
        Route::match(['get','post'],'edit_equipment/{id}', [AdminEquipmentController::class, 'edit_equipment']);
        Route::get('equipment_status/{id}/{status}', [AdminEquipmentController::class, 'equipment_status']);

        //Consumable

        Route::get('consumables', [AdminConsumableController::class, 'index']);
        Route::post('get_consumables', [AdminConsumableController::class, 'get_consumables']);
        Route::match(['get','post'],'add_consumable', [AdminConsumableController::class, 'add_consumable']);
        Route::match(['get','post'],'edit_consumable/{id}', [AdminConsumableController::class, 'edit_consumable']);
        Route::get('consumable_status/{id}/{status}', [AdminConsumableController::class, 'consumable_status']);

        //Location

        Route::get('locations', [AdminLocationController::class, 'index']);
        Route::post('get_locations', [AdminLocationController::class, 'get_locations']);
        Route::match(['get','post'],'add_location', [AdminLocationController::class, 'add_location']);
        Route::match(['get','post'],'edit_location/{id}', [AdminLocationController::class, 'edit_location']);
        Route::get('location_status/{id}/{status}', [AdminLocationController::class, 'location_status']);

        //Department

        Route::get('departments', [AdminDepartmentController::class, 'index']);
        Route::post('get_departments', [AdminDepartmentController::class, 'get_departments']);
        Route::match(['get','post'],'add_department', [AdminDepartmentController::class, 'add_department']);
        Route::match(['get','post'],'edit_department/{id}', [AdminDepartmentController::class, 'edit_department']);
        Route::get('department_status/{id}/{status}', [AdminDepartmentController::class, 'department_status']);

        //Manufacturer

        Route::get('manufacturers', [AdminManufacturerController::class, 'index']);
        Route::post('get_manufacturers', [AdminManufacturerController::class, 'get_manufacturers']);
        Route::match(['get','post'],'add_manufacturer', [AdminManufacturerController::class, 'add_manufacturer']);
        Route::match(['get','post'],'edit_manufacturer/{id}', [AdminManufacturerController::class, 'edit_manufacturer']);
        Route::get('manufacturer_status/{id}/{status}', [AdminManufacturerController::class, 'manufacturer_status']);

        //Model

        Route::get('models', [AdminModelController::class, 'index']);
        Route::post('get_models', [AdminModelController::class, 'get_models']);
        Route::match(['get','post'],'add_model', [AdminModelController::class, 'add_model']);
        Route::match(['get','post'],'edit_model/{id}', [AdminModelController::class, 'edit_model']);
        Route::get('model_status/{id}/{status}', [AdminModelController::class, 'model_status']);

        //Profile

        Route::match(['get','post'],'profile', [AdminProfileController::class, 'index']);
        Route::post('change_password', [AdminProfileController::class, 'change_password']);
        Route::post('check_old_password', [AdminProfileController::class, 'check_old_password']);

        Route::get('logout', [AdminLogoutController::class, 'index']);

    });

});

Route::middleware(['checkstafflogin'])->group(function () {

    Route::match(['get','post'],'staff', [StaffLoginController::class, 'index']);
    Route::match(['get','post'],'staff_forgot_password', [StaffLoginController::class, 'forgot_password']);

});

Route::middleware(['checkstaff'])->group(function () {

    Route::prefix('staff')->group(function () {

        //Dashboard

        Route::get('dashboard', [StaffDashboardController::class, 'index']);

        //Booking

        Route::get('bookings', [StaffBookingController::class, 'index']);
        Route::post('get_bookings', [StaffBookingController::class, 'get_bookings']);
        Route::get('view_booking/{id}', [StaffBookingController::class, 'view_booking']);
        Route::post('update_booking_status/{id}', [StaffBookingController::class, 'update_booking_status']);
        Route::post('upload_booking_files/{id}', [StaffBookingController::class, 'upload_booking_files']);
        Route::post('update_voucher/{id}', [StaffBookingController::class, 'update_voucher']);
        Route::post('add_working_hour/{id}', [StaffBookingController::class, 'add_working_hour']);
        Route::post('upload_photographs/{id}', [StaffBookingController::class, 'upload_photographs']);
        Route::get('download_booking/{id}', [StaffBookingController::class, 'download_booking']);

        // Purchase

        Route::get('purchase_request', [StaffPurchaseRequestController::class, 'index']);
        Route::match(['get','post'],'add_purchase_request', [StaffPurchaseRequestController::class, 'add_purchase_request']);
        Route::post('get_purchase_requests', [StaffPurchaseRequestController::class, 'get_purchase_request']);
        Route::match(['get','post'],'edit_purchase_request/{id}', [StaffPurchaseRequestController::class, 'edit_purchase_request']);
        Route::get('delete_purchase_request/{id}', [StaffPurchaseRequestController::class, 'destroy']);

        //Attendance

        Route::get('attendances', [StaffAttendanceController::class, 'index']);
        Route::post('get_attendances', [StaffAttendanceController::class, 'get_attendances']);
        Route::match(['get','post'],'add_attendance', [StaffAttendanceController::class, 'add_attendance']);
        Route::match(['get','post'],'edit_attendance/{id}', [StaffAttendanceController::class, 'edit_attendance']);

        //Timesheet

        Route::get('timesheets', [StaffTimesheetController::class, 'index']);
        Route::post('get_timesheets', [StaffTimesheetController::class, 'get_timesheets']);
        Route::match(['get','post'],'add_timesheet', [StaffTimesheetController::class, 'add_timesheet']);
        Route::match(['get','post'],'edit_timesheet/{id}', [StaffTimesheetController::class, 'edit_timesheet']);

        //Leave

        Route::get('leaves', [StaffLeaveController::class, 'index']);
        Route::post('get_leaves', [StaffLeaveController::class, 'get_leaves']);
        Route::match(['get','post'],'add_leave', [StaffLeaveController::class, 'add_leave']);
        Route::match(['get','post'],'edit_leave/{id}', [StaffLeaveController::class, 'edit_leave']);

        //Leave Request

        Route::get('leave_requests', [StaffLeaveRequestController::class, 'index']);
        Route::post('get_leave_requests', [StaffLeaveRequestController::class, 'get_leave_requests']);
        Route::post('leave_requests_status', [StaffLeaveRequestController::class, 'leave_requests_status']);
        Route::post('add_leave_requests_status', [StaffLeaveRequestController::class, 'add_leave_requests_status']);

        //Asset

        Route::get('assets', [StaffAssetController::class, 'index']);
        Route::post('get_assets', [StaffAssetController::class, 'get_assets']);
        Route::get('view_asset/{id}', [StaffAssetController::class, 'view_asset']);

        //Vehicle

        Route::get('vehicles', [StaffVehicleController::class, 'index']);
        Route::post('get_vehicles', [StaffVehicleController::class, 'get_vehicles']);

        //Trip Log

        Route::get('trip_logs/{id}', [StaffTripLogController::class, 'index']);
        Route::post('get_trip_logs', [StaffTripLogController::class, 'get_trip_logs']);
        Route::match(['get','post'],'add_trip_log/{id}', [StaffTripLogController::class, 'add_trip_log']);
        Route::match(['get','post'],'edit_trip_log/{id}', [StaffTripLogController::class, 'edit_trip_log']);
        Route::get('trip_log_status/{id}/{status}', [StaffTripLogController::class, 'trip_log_status']);

        //Fuel Log

        Route::get('fuel_logs/{id}', [StaffFuelLogController::class, 'index']);
        Route::post('get_fuel_logs', [StaffFuelLogController::class, 'get_fuel_logs']);
        Route::match(['get','post'],'add_fuel_log/{id}', [StaffFuelLogController::class, 'add_fuel_log']);
        Route::match(['get','post'],'edit_fuel_log/{id}', [StaffFuelLogController::class, 'edit_fuel_log']);
        Route::get('fuel_log_status/{id}/{status}', [StaffFuelLogController::class, 'fuel_log_status']);

        //Insurance

        Route::get('insurances/{id}', [StaffInsuranceController::class, 'index']);
        Route::post('get_insurances', [StaffInsuranceController::class, 'get_insurances']);
        Route::match(['get','post'],'add_insurance/{id}', [StaffInsuranceController::class, 'add_insurance']);
        Route::match(['get','post'],'edit_insurance/{id}', [StaffInsuranceController::class, 'edit_insurance']);
        Route::get('insurance_status/{id}/{status}', [StaffInsuranceController::class, 'insurance_status']);

        //Service Log

        Route::get('service_logs/{id}', [StaffServiceLogController::class, 'index']);
        Route::post('get_service_logs', [StaffServiceLogController::class, 'get_service_logs']);
        Route::match(['get','post'],'add_service_log/{id}', [StaffServiceLogController::class, 'add_service_log']);
        Route::match(['get','post'],'edit_service_log/{id}', [StaffServiceLogController::class, 'edit_service_log']);
        Route::get('service_log_status/{id}/{status}', [StaffServiceLogController::class, 'service_log_status']);

        //Clean Log

        Route::get('cleaning_logs/{id}', [StaffCleanLogController::class, 'index']);
        Route::post('get_cleaning_logs', [StaffCleanLogController::class, 'get_cleaning_logs']);
        Route::match(['get','post'],'add_cleaning_log/{id}', [StaffCleanLogController::class, 'add_cleaning_log']);
        Route::match(['get','post'],'edit_cleaning_log/{id}', [StaffCleanLogController::class, 'edit_cleaning_log']);
        Route::get('cleaning_log_status/{id}/{status}', [StaffCleanLogController::class, 'cleaning_log_status']);

        //Repair Log

        Route::get('repair_logs/{id}', [StaffRepairLogController::class, 'index']);
        Route::post('get_repair_logs', [StaffRepairLogController::class, 'get_repair_logs']);
        Route::match(['get','post'],'add_repair_log/{id}', [StaffRepairLogController::class, 'add_repair_log']);
        Route::match(['get','post'],'edit_repair_log/{id}', [StaffRepairLogController::class, 'edit_repair_log']);
        Route::get('repair_log_status/{id}/{status}', [StaffRepairLogController::class, 'repair_log_status']);

        //Accident

        Route::get('accidents/{id}', [StaffAccidentController::class, 'index']);
        Route::post('get_accidents', [StaffAccidentController::class, 'get_accidents']);
        Route::match(['get','post'],'add_accident/{id}', [StaffAccidentController::class, 'add_accident']);
        Route::match(['get','post'],'edit_accident/{id}', [StaffAccidentController::class, 'edit_accident']);
        Route::get('accident_status/{id}/{status}', [StaffAccidentController::class, 'accident_status']);

        //Inspection

        Route::get('inspections/{id}', [StaffInspectionController::class, 'index']);
        Route::post('get_inspections', [StaffInspectionController::class, 'get_inspections']);
        Route::match(['get','post'],'add_inspection/{id}', [StaffInspectionController::class, 'add_inspection']);
        Route::match(['get','post'],'edit_inspection/{id}', [StaffInspectionController::class, 'edit_inspection']);
        Route::post('add_exterior_inspection/{id}', [StaffInspectionController::class, 'add_exterior_inspection']);
        Route::post('add_interior_inspection/{id}', [StaffInspectionController::class, 'add_interior_inspection']);
        Route::post('add_hood_inspection/{id}', [StaffInspectionController::class, 'add_hood_inspection']);
        Route::post('add_uvehicle_inspection/{id}', [StaffInspectionController::class, 'add_uvehicle_inspection']);
        Route::post('add_test_inspection/{id}', [StaffInspectionController::class, 'add_test_inspection']);
        Route::get('inspection_status/{id}/{status}', [StaffInspectionController::class, 'inspection_status']);

        //Profile

        Route::match(['get','post'],'profile', [StaffProfileController::class, 'index']);
        Route::post('add_staff_qualification', [StaffProfileController::class, 'add_staff_qualification']);
        Route::post('add_staff_induction', [StaffProfileController::class, 'add_staff_induction']);
        Route::post('add_staff_licence', [StaffProfileController::class, 'add_staff_licence']);
        Route::post('add_staff_identification', [StaffProfileController::class, 'add_staff_identification']);
        Route::post('add_staff_document', [StaffProfileController::class, 'add_staff_document']);
        Route::match(['get','post'],'change_password', [StaffProfileController::class, 'change_password']);
        Route::post('check_old_password', [StaffProfileController::class, 'check_old_password']);

        Route::get('logout', [StaffLogoutController::class, 'index']);

    });
});

Route::get('update_job_status/{booking}/{staff}/{status}', [JobController::class, 'index']);