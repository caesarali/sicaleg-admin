<?php

namespace App\Http\Controllers\API\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Team\DapilResource;
use App\Http\Resources\Team\TpsResource;
use App\Http\Resources\Team\VolunteerResource;

use App\Models\CandidateArea;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\VotingPlace;
use App\Models\Volunteer;

class VolunteerController extends Controller
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
            $volunteers = Volunteer::whereIn('locationable_id', $tps->pluck('id'))->get();
            return VolunteerResource::collection($volunteers)->additional([
                'references' => $tps->map(function ($item) {
                    return ['id' => $item->id, 'name' => 'TPS ' . $item->name];
                })
            ]);
        }

        return DapilResource::collection($dapil);
    }
}
