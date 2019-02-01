<?php

namespace App\Http\Controllers\API\Election;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Election\C1Resource;

use App\Models\CandidateArea;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\VotingPlace;

class C1Controller extends Controller
{
    public function index(Request $request)
    {
        $c1 = CandidateArea::all();
        $kabupaten = '';
        $kecamatan = '';
        $kelurahan = '';

        if ($request->has('city_id')) {
            $c1 = District::where('city_id', $request->city_id)->orderBy('name', 'asc')->get();
            $location = City::find($request->city_id);
            $kabupaten = $location->name;
        }
        if ($request->has('district_id')) {
            $c1 = Village::where('district_id', $request->district_id)->orderBy('name', 'asc')->get();
            $location = District::find($request->district_id);
            $kecamatan = $location->name;
            $kabupaten = $location->city->name;
        }
        if ($request->has('village_id')) {
            $c1 = VotingPlace::where('village_id', $request->village_id)->orderBy('name', 'asc')->get();
            $location = Village::find($request->village_id);
            $kelurahan = $location->name;
            $kecamatan = $location->district->name;
            $kabupaten = $location->district->city->name;
        }

        return C1Resource::collection($c1)->additional([
            'meta' => [
                'kabupaten' => $kabupaten,
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
            ]
        ]);
    }
}
