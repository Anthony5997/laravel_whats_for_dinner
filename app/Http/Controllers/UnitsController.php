<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
{

    public function getAllUnits()
    {
       
        $allUnits = Unit::all();
        $response = ["total_results" => count($allUnits), "results" => $allUnits];
        return response()->json($response, 200);
    }
}
