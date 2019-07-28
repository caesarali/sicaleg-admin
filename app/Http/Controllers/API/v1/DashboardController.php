<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Voter;
use App\Models\Volunteer;
use App\Models\Supporter;
use App\Models\Party;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $caleg = Candidate::all()->first();
        $partai = Party::all()->first();
        $caleg['partai'] = $partai->name;

        $totalDpt = Voter::count();
        $totalRelawan = Volunteer::count();
        $totalDukungan = Supporter::count();
        $targetInPercent = 20;
        $targetDukungan = round($totalDpt * $targetInPercent / 100);

        $data = [
            'caleg' => $caleg,
            'relawan' => $totalRelawan,
            'dpt' => $totalDpt,
            'dukungan' => $totalDukungan,
            'target' => [
                'total' => $targetDukungan,
                'percent' => $targetInPercent
            ]
        ];

        return response()->json(['data' => $data]);
    }
}
