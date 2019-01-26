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
use App\Models\Voter;
use App\Models\RefDisability as Disability;

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
        if ($request->has('tps_id')) {
            $tps = Voter::where('locationable_id', $request->tps_id)->orderBy('name', 'asc')->paginate(50);
            return DptResource::collection($tps)->additional([
                'ref_disabilities' => Disability::all()
            ]);
        }

        return DapilResource::collection($dapil);
    }

    public function store(Request $request)
    {
        $request->validate([
            'locationable_id' => 'required|integer',
            'kk' => 'required|numeric|digits:16',
            'nik' => 'required|numeric|digits:16|unique:voters',
            'name' => 'required|string|max:50',
            'birth_place' => 'required|string|max:50',
            'birth_date' => 'required|date_format:"d/m/Y"',
            'marital_status' => 'required|in:b,s,p',
            'gender' => 'required|in:p,l',
            'addr_street' => 'required|string|max:50',
            'addr_rt' => 'required|numeric|digits:3',
            'addr_rw' => 'required|numeric|digits:3',
            'disability_id' => 'nullable|integer',
            'information' => 'nullable|string'
        ]);
        $request->request->add(['locationable_type' => VotingPlace::class]);

        $dpt = Voter::create($request->all());

        return (new DptResource($dpt))->additional(['message' => 'Data Pemilih ditambahkan.'], 200);
    }

    public function update(Request $request, Voter $dpt)
    {
        $request->validate([
            'kk' => 'required|numeric|digits:16',
            'nik' => 'required|numeric|digits:16|unique:voters,nik,' . $dpt->id,
            'name' => 'required|string|max:50',
            'birth_place' => 'required|string|max:50',
            'birth_date' => 'required|date_format:"d/m/Y"',
            'marital_status' => 'required|in:b,s,p',
            'gender' => 'required|in:p,l',
            'addr_street' => 'required|string|max:50',
            'addr_rt' => 'required|numeric|digits:3',
            'addr_rw' => 'required|numeric|digits:3',
            'disability_id' => 'nullable|integer',
            'information' => 'nullable|string'
        ]);
        $dpt->update($request->all());
        return (new DptResource($dpt))->additional(['message' => 'Perubahan Data Pemilih disimpan.'], 200);
    }

    public function destroy(Voter $dpt)
    {
        $dpt->delete();
        return response()->json(['message', 'Data Pemilih dihapus'], 200);
    }
}
