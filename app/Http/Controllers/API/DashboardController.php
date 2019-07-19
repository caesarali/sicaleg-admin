<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Voter;
use App\Models\Volunteer;
use App\Models\Supporter;
use App\Models\Party;

class DashboardController extends Controller
{
    public function index()
    {
        $caleg = Candidate::all()->first();
        $partai = Party::all()->first();
        $caleg['partai'] = $partai->name;

        $totalDpt = Voter::count();
        $totalRelawan = Volunteer::count();
        $totalDukungan = Supporter::count();
        $targetDukungan = $totalDpt * 20 / 100;

        $data = [
            'caleg' => $caleg,
            'relawan' => $totalRelawan,
            'dpt' => $totalDpt,
            'dukungan' => $totalDukungan,
            'target' => $targetDukungan
        ];

        return response()->json(['data' => $data]);
    }
}
