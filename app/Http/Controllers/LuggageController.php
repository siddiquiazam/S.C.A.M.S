<?php

namespace App\Http\Controllers;

use App\Models\Luggage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class LuggageController extends Controller
{
    public function scanLuggage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'luggage_id' => 'required|string'
        ]);
        date_default_timezone_set('Asia/Kolkata');
        Config::set('app.timezone', 'Asia/Kolkata');
        if ($validator->fails()) {
            return [
                "success" => false,
                "message" => "Validation error"
            ];
        }

        $validated = $validator->validated();

        $luggage = Luggage::find($validated['luggage_id']);

        if (!$luggage) {
            return [
                'success' => false,
                'message' => 'Invalid QR code'
            ];
        }
        if ($luggage->total_scans == 4) {
            return [
                'success' => false,
                'message' => 'Luggage already scanned 4 times'
            ];
        }
        $scans = $luggage->scans;
        $key = "scan" . ($luggage->total_scans + 1);
        $scans[$key] = [
            'is_scanned' => true,
            'timestamp' => Carbon::now()->toDateTimeString()
        ];
        $luggage->scans = $scans;
        $luggage->total_scans = $luggage->total_scans + 1;
        $saved = $luggage->save();
        if ($saved) {
            return [
                "success" => true,
                "message" => "Luggage Scanned Successfully"
            ];
        }
    }
}
