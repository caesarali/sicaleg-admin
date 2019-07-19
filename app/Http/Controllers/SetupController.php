<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Candidate;
use App\Models\Province;
use App\Models\City;

class SetupController extends Controller
{
    public function profile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'number' => 'required|integer',
            'locationable_id' => 'required|integer',
            'dapil' => 'required|string|max:100',
        ]);

        $level = env('CALEG_LEVEL');

        if ($level == 'dpr') {
            $locationable_type = Province::class;
        } else {
            $locationable_type = City::class;
        }

        $candidate = Candidate::create([
            'name' => $request->name,
            'number' => $request->number,
            'level' => $level,
            'dapil' => $request->dapil,
            'locationable_type' => $locationable_type,
            'locationable_id' => $request->locationable_id
        ]);

        return redirect()->back();
    }

    public function dapil(Request $request) {

    }
}
