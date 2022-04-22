<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LuggageController extends Controller
{
    public function scanLuggage(Request $request)
    {
        return [
            "success" => true,
            "data" => "hello world!"
        ];
        $validator = Validator::make($request->all(), [
            'luggage_id' => 'required|string',
            'timestamp' => 'required|string'
        ]);

        if ($validator->fails()) {
            return [
                "success" => false,
                "message" => "Validation error",
                "data" => $validator->errors()->all()
            ];
        }

        $validated = $validator->validated();

        $luggage = DB::table('Luggage')->find($validated['luggage_id']);

        if (!$luggage) {
            return [
                'success' => false,
                'message' => 'Luggage not found',
                'data' => []
            ];
        }

        return [
            "success" => true,
            "message" => "Data fetched successfully",
            "data" => $luggage
        ];
    }
}
