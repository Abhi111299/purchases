<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Location;
use App\Models\Staff;
use App\Models\PurchaseRequest;
use Validator;
use Auth;
use Mail;

class PurchaseRequestController extends BaseController
{
    public function updatePurchaseRequestStatus($id, $status)
    {
        // Validate status
        $validStatuses = ['Approved', 'Rejected'];
        if (!in_array($status, $validStatuses)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status'
            ], 400);
        }

        // Find the purchase request by ID
        $purchaseRequest = PurchaseRequest::find($id);

        if (!$purchaseRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase request not found'
            ], 404);
        }

        // Update the status
        $purchaseRequest->status = $status;
        $purchaseRequest->save();

        return redirect()->route('thank_you');
    }
}
