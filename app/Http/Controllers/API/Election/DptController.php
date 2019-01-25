<?php

namespace App\Http\Controllers\API\Election;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Election\DapilResource;
use App\Http\Resources\Election\TpsResource;
use App\Http\Resources\Election\DptResource;

use App\Models\CandidateArea;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\VotingPlace;

use Indonesia;

class DptController extends Controller
{
    public function index(Request $request)
    {
        $dapil = CandidateArea::all();

        if ($request->has('city_id')) {
            $dapil = District::where('city_id', $request->city_id)->get();
        }
        if ($request->has('district_id')) {
            $dapil = Village::where('district_id', $request->district_id)->get();
        }
        if ($request->has('village_id')) {
            $tps = VotingPlace::where('village_id', $request->village_id)->orderBy('name', 'asc')->get();
            return TpsResource::collection($tps);
        }

        return DapilResource::collection($dapil);
    }
}
