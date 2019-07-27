<?php

namespace App\Http\Controllers\API\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\CandidateArea;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function index()
    {
        $caleg = Candidate::all()->first();
        $dapil = CandidateArea::with(['locationable'])->get();
        $dapil = $dapil->map(function ($item) {
            return $item->locationable->name;
        });
        $partai = DB::table('parties')->first();

        $response = [
            'caleg' => $caleg,
            'dapil' => $dapil,
            'partai' => $partai
        ];

        return response()->json($response, 200);
    }
}
