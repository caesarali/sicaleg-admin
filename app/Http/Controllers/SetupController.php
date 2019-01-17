<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Candidate;
use App\Models\CandidateLevel;
use App\Models\CandidateArea;
use App\Models\Group;
use App\Models\Province;
use App\Models\Cities;

class SetupController extends Controller
{
    public function profile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'number' => 'required|integer',
            'locationable_id' => 'required|integer',
            'locationable_name' => 'required|string|max:100',
        ]);

        $level = CandidateLevel::where('code', env('CALEG_LEVEL', 'drp'))->first();

        if (env('CALEG_LEVEL') == 'dpr') {
            $locationable_type = Province::class;
        } else {
            $locationable_type = City::class;
        }

        $candidate = Candidate::create([
            'name' => $request->name,
            'number' => $request->number,
            'level_id' => $level->id,
            'locationable_type' => $locationable_type,
            'locationable_id' => $request->locationable_id,
            'locationable_name' => $request->locationable_name
        ]);

        return redirect()->back();
    }

    public function dapil(Request $request) {

    }
}
