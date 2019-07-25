<?php

namespace App\Http\Controllers\API\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Voter;

class VoterController extends Controller
{
    public function search($nik)
    {
        $voter = Voter::with('tps')->where('nik', $nik)->first();
        return response()->json($voter);
    }
}
