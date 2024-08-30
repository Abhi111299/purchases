<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StaffLoginController;
use App\Http\Controllers\API\StaffLocationController;
use App\Http\Controllers\API\StaffEquipmentController;
use App\Http\Controllers\API\StaffConsumableController;
use App\Http\Controllers\API\StaffClientController;
use App\Http\Controllers\API\StaffController;
use App\Http\Controllers\API\StaffJobController;
use App\Http\Controllers\API\StaffTimesheetController;
use App\Http\Controllers\API\StaffAttendanceController;
use App\Http\Controllers\API\StaffLeaveController;
use App\Http\Controllers\API\StaffAssetController;
use App\Http\Controllers\API\StaffVehicleController;
use App\Http\Controllers\API\StaffTripLogController;
use App\Http\Controllers\API\StaffFuelLogController;
use App\Http\Controllers\API\StaffInsuranceController;
use App\Http\Controllers\API\StaffServiceLogController;
use App\Http\Controllers\API\StaffCleanLogController;
use App\Http\Controllers\API\StaffRepairLogController;
use App\Http\Controllers\API\StaffAccidentController;
use App\Http\Controllers\API\StaffInspectionController;
use App\Http\Controllers\API\PurchaseRequestController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('unauthenticated',function(){
    return response()->json(['message' => 'Invalid token', 'error' => 'Invalid token', 'status' => false], 401);
})->name('unauthenticated-api');

Route::get('/thank_you', function() {
    return view('staff.emails.thank_you'); // Create a simple thank-you view
});

Route::get('/purchase-request/update-purchase-request-status/{id}/{status}', [PurchaseRequestController::class, 'updatePurchaseRequestStatus']);


Route::post('login', [StaffLoginController::class, 'index']);

Route::middleware('auth:api')->group( function () {
    
    Route::get('locations', [StaffLocationController::class, 'index']);

    Route::get('equipments', [StaffEquipmentController::class, 'index']);

    Route::get('consumables', [StaffConsumableController::class, 'index']);

    Route::get('clients', [StaffClientController::class, 'index']);

    Route::get('staffs', [StaffController::class, 'index']);
    Route::get('safety_inductions', [StaffController::class, 'safety_inductions']);
    Route::post('add_safety_induction', [StaffController::class, 'add_safety_induction']);
    Route::get('safety_induction_details/{id}', [StaffController::class, 'safety_induction_details']);
    Route::post('edit_safety_induction/{id}', [StaffController::class, 'edit_safety_induction']);
    Route::get('safety_licences', [StaffController::class, 'safety_licences']);
    Route::post('add_safety_licence', [StaffController::class, 'add_safety_licence']);
    Route::get('safety_licence_details/{id}', [StaffController::class, 'safety_licence_details']);
    Route::post('edit_safety_licence/{id}', [StaffController::class, 'edit_safety_licence']);
    Route::get('safety_type', [StaffController::class, 'safety_type']);
    Route::get('payment_status', [StaffController::class, 'payment_status']);
    Route::get('trainings', [StaffController::class, 'trainings']);

    Route::get('jobs', [StaffJobController::class, 'index']);
    Route::get('job_status', [StaffJobController::class, 'job_status']);    
    Route::get('job_general/{id}', [StaffJobController::class, 'job_general']);
    Route::post('job_update_status/{id}', [StaffJobController::class, 'job_update_status']);
    Route::get('job_working_hours/{id}', [StaffJobController::class, 'job_working_hours']);
    Route::get('technicians', [StaffJobController::class, 'technicians']);
    Route::post('add_working_hour/{id}', [StaffJobController::class, 'add_working_hour']);
    Route::get('job_voucher/{id}', [StaffJobController::class, 'job_voucher']);
    Route::post('update_voucher/{id}', [StaffJobController::class, 'update_voucher']);
    Route::get('photographs/{id}', [StaffJobController::class, 'photographs']);
    Route::post('update_photographs/{id}', [StaffJobController::class, 'update_photographs']);
    Route::get('upload_files/{id}', [StaffJobController::class, 'upload_files']);
    Route::post('update_upload_files/{id}', [StaffJobController::class, 'update_upload_files']);

    Route::get('timesheets', [StaffTimesheetController::class, 'index']);
    Route::post('add_timesheet', [StaffTimesheetController::class, 'add_timesheet']);
    Route::get('timesheet_status', [StaffTimesheetController::class, 'timesheet_status']);

    Route::get('attendances', [StaffAttendanceController::class, 'index']);
    Route::post('add_attendance', [StaffAttendanceController::class, 'add_attendance']);
    Route::get('attendance_type', [StaffAttendanceController::class, 'attendance_type']);

    Route::get('leaves', [StaffLeaveController::class, 'index']);
    Route::post('add_leave', [StaffLeaveController::class, 'add_leave']);
    Route::get('leave_detail/{id}', [StaffLeaveController::class, 'leave_detail']);
    Route::post('edit_leave/{id}', [StaffLeaveController::class, 'edit_leave']);
    Route::get('leave_type', [StaffLeaveController::class, 'leave_type']);
    Route::get('managers', [StaffLeaveController::class, 'managers']);

    Route::get('assets', [StaffAssetController::class, 'index']);
    Route::get('asset_details/{id}', [StaffAssetController::class, 'asset_details']);

    Route::get('vehicles', [StaffVehicleController::class, 'index']);

    Route::get('trip_logs/{id}', [StaffTripLogController::class, 'index']);
    Route::post('add_trip_log/{id}', [StaffTripLogController::class, 'add_trip_log']);
    Route::get('trip_log_detail/{id}', [StaffTripLogController::class, 'trip_log_detail']);
    Route::post('edit_trip_log/{id}', [StaffTripLogController::class, 'edit_trip_log']);

    Route::get('fuel_logs/{id}', [StaffFuelLogController::class, 'index']);
    Route::post('add_fuel_log/{id}', [StaffFuelLogController::class, 'add_fuel_log']);
    Route::get('fuel_log_detail/{id}', [StaffFuelLogController::class, 'fuel_log_detail']);
    Route::post('edit_fuel_log/{id}', [StaffFuelLogController::class, 'edit_fuel_log']);

    Route::get('insurances/{id}', [StaffInsuranceController::class, 'index']);
    Route::post('add_insurance/{id}', [StaffInsuranceController::class, 'add_insurance']);
    Route::get('insurance_detail/{id}', [StaffInsuranceController::class, 'insurance_detail']);
    Route::post('edit_insurance/{id}', [StaffInsuranceController::class, 'edit_insurance']);
    Route::get('coverages', [StaffInsuranceController::class, 'coverages']);

    Route::get('service_logs/{id}', [StaffServiceLogController::class, 'index']);
    Route::post('add_service_log/{id}', [StaffServiceLogController::class, 'add_service_log']);
    Route::get('service_log_detail/{id}', [StaffServiceLogController::class, 'service_log_detail']);
    Route::post('edit_service_log/{id}', [StaffServiceLogController::class, 'edit_service_log']);

    Route::get('cleaning_logs/{id}', [StaffCleanLogController::class, 'index']);
    Route::post('add_cleaning_log/{id}', [StaffCleanLogController::class, 'add_cleaning_log']);
    Route::get('cleaning_log_detail/{id}', [StaffCleanLogController::class, 'cleaning_log_detail']);
    Route::post('edit_cleaning_log/{id}', [StaffCleanLogController::class, 'edit_cleaning_log']);

    Route::get('repair_logs/{id}', [StaffRepairLogController::class, 'index']);
    Route::post('add_repair_log/{id}', [StaffRepairLogController::class, 'add_repair_log']);
    Route::get('repair_log_detail/{id}', [StaffRepairLogController::class, 'repair_log_detail']);
    Route::post('edit_repair_log/{id}', [StaffRepairLogController::class, 'edit_repair_log']);

    Route::get('accidents/{id}', [StaffAccidentController::class, 'index']);
    Route::post('add_accident/{id}', [StaffAccidentController::class, 'add_accident']);
    Route::get('accident_detail/{id}', [StaffAccidentController::class, 'accident_detail']);
    Route::post('edit_accident/{id}', [StaffAccidentController::class, 'edit_accident']);

    Route::get('inspections/{id}', [StaffInspectionController::class, 'index']);
    Route::post('add_inspection/{id}', [StaffInspectionController::class, 'add_inspection']);
    Route::get('inspection_detail/{id}', [StaffInspectionController::class, 'inspection_detail']);
    Route::post('edit_inspection/{id}', [StaffInspectionController::class, 'edit_inspection']);
    Route::get('exterior_inspection_detail/{id}', [StaffInspectionController::class, 'exterior_inspection_detail']);
    Route::post('edit_exterior_inspection/{id}', [StaffInspectionController::class, 'edit_exterior_inspection']);
    Route::get('interior_inspection_detail/{id}', [StaffInspectionController::class, 'interior_inspection_detail']);
    Route::post('edit_interior_inspection/{id}', [StaffInspectionController::class, 'edit_interior_inspection']);
    Route::get('under_hood_detail/{id}', [StaffInspectionController::class, 'under_hood_detail']);
    Route::post('edit_under_hood/{id}', [StaffInspectionController::class, 'edit_under_hood']);
    Route::get('under_vehicle_detail/{id}', [StaffInspectionController::class, 'under_vehicle_detail']);
    Route::post('edit_under_vehicle/{id}', [StaffInspectionController::class, 'edit_under_vehicle']);
    Route::get('functional_test_detail/{id}', [StaffInspectionController::class, 'functional_test_detail']);
    Route::post('edit_functional_test/{id}', [StaffInspectionController::class, 'edit_functional_test']);
    Route::get('inspection_status', [StaffInspectionController::class, 'inspection_status']);

});