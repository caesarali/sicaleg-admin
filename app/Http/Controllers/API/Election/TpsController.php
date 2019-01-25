<?php

namespace App\Http\Controllers\API\Election;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Election\TpsResource;

use App\Models\VotingPlace;

class TpsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'village_id' => 'required|integer'
        ]);

        $tps = VotingPlace::create($request->all());

        return (new TpsResource($tps))->additional(['message' => 'Daerah pemilihan berhasil ditambahkan.'], 200);
    }

    public function destroy($id)
    {
        $tps = VotingPlace::destroy($id);
        return response()->json(['message' => 'TPS berhasil dihapus.'], 200);
    }
}
