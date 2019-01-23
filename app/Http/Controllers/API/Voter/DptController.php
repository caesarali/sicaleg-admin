<?php

namespace App\Http\Controllers\API\Voter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Voter\DPT\ByDapilResource;
use App\Http\Resources\Voter\DPT\ByTpsResource;

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
            return $this->tps($request);
        }

        return ByDapilResource::collection($dapil);
    }

    public function tps(Request $request)
    {
        $tps = VotingPlace::where('village_id', $request->village_id)->get();
        return ByTpsResource::collection($tps);
    }
}
