<?php

namespace App\Http\Controllers\API\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Candidate\DapilResource;

use App\Models\Candidate;
use App\Models\CandidateArea;

class DapilController extends Controller
{
    public function index()
    {
        $dapil = CandidateArea::all();
        $candidate = Candidate::all()->first();
        $locations = $candidate->locationable->childs;
        return DapilResource::collection($dapil)->additional([
            'name' => $candidate->dapil,
            'locations' => $locations
        ]);
    }

    public function store(Request $request)
    {
        $message = [
            'locationable_id.unique' => 'Lokasi ini sudah ada dalam Daerah Pemilihan.'
        ];
        $request->validate([
            'locationable_id' => 'required|unique:candidate_areas'
        ], $message);

        $candidate = Candidate::all()->first();
        $locationable_type = $candidate->candidateLevel->locationable_child;

        $dapil = CandidateArea::create([
            'locationable_type' => $locationable_type,
            'locationable_id' => $request->locationable_id,
        ]);

        return (new DapilResource($dapil))->additional(['message' => 'Daerah pemilihan berhasil ditambahkan.'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $dapil = CandidateArea::destroy($id);
        return response()->json(['message' => 'Daerah pemilihan berhasil dihapus.'], 200);
    }
}
